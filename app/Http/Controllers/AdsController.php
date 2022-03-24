<?php

namespace App\Http\Controllers;

use App\Models\Ads;
use Illuminate\Http\Request;

class AdsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user_id = $request->user()->id;
        $fields = $request->validate([
            'leftside_image' => 'string',
            'leftside_redirect_url' => 'string',
            'rightside_image' => 'string',
            'rightside_redirect_url' => 'string',
            'banner_image' => 'string',
            'banner_redirect_url' => 'string'
        ]);

        $check_ifExist = Ads::where('user_id', $user_id)->first();


        if (!$check_ifExist) {
            $ads = Ads::create([
                'user_id' => $user_id,
                'leftside_image' => $fields['leftside_image'],
                'leftside_redirect_url' => $fields['leftside_redirect_url'],
                'rightside_image' => $fields['rightside_image'],
                'rightside_redirect_url' => $fields['rightside_redirect_url'],
                'banner_image' => $fields['banner_image'],
                'banner_redirect_url' => $fields['banner_redirect_url'],
            ]);

            return response()->json($ads, 201);
        } else {
            return abort(409, 'Ads already exist for this user!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($user_id)
    {
        return Ads::where('user_id', $user_id)->first();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user_id = $request->user()->id;


        $current_user = auth()->user();
        $ads = Ads::find($id);

        if ($current_user->id === $ads->user_id) {
            $update =  $ads->update($request->all() + ['user_id' => $user_id]);
            return response()->json($update, 200);
        } else {
            return abort(401, 'you not own this ads to update!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $current_user = auth()->user();
        $ads = Ads::find($id);


        if ($current_user->id === $ads->user_id) {
            $del = Ads::destroy($id);
            if ($del === 0) {
                $response = [
                    'message' => 'Not found !',
                    'code' => 404
                ];
                return response($response);
            } else {
                $response = [
                    'message' => 'success',
                    'code' => 200
                ];
                return response($response);
            }
        } else {
            return abort(401, 'you not own this ads to delete!');
        }
    }
}
