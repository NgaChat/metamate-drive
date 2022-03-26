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
        return Ads::where('user_id', auth()->user()->id)->first();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user_id = auth()->user()->id;

        $check_ifExist = Ads::where('user_id', $user_id)->first();

        if (!$check_ifExist) {
            $ads = Ads::create($request->all() + ['user_id' => $user_id]);

            return response()->json($ads, 201);
        } else {
            return abort(409, 'Ads already exist for this user!');
        }
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
        $user_id = auth()->user()->id;


        $ads = Ads::find($id);

        if ($user_id === $ads->user_id) {
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
                return abort(404, 'Not found for this ads.');
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
