<?php

namespace App\Http\Controllers;

use App\Models\Drive;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DriveController extends Controller
{
    public function __construct()
    {
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        // $offset = request('offset') ?: '0';
        // $limit = request('limit') ?: '30';
        // $id = $request->header('id');
        // $drives = Drive::where('user_id', $id)->offset($offset)->limit($limit)->latest()->get();
        // return $drives;
        $drives = Drive::where('user_id', $request->user()->id)->latest('created_at')->paginate(10);
        return response()->json($drives, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'file_id' => 'required',
            'file_size' => 'required',
            'mime_type' => 'required',
            'thumb' => 'required',
            'down_count' => 'required'
        ]);

        $drive = Drive::create($request->all() + ['user_id' => $request->user()->id, 'slug' => Str::slug($request->name)]);

        return response()->json($drive, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Drive::find($id);
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

    // Currently not using this update method
    public function update(Request $request, $id, Drive $drive)
    {
        $request->validate([
            'name' => 'required',
            'file_id' => 'required',
            'file_size' => 'required',
            'mime_type' => 'required',
            'thumb' => 'required',
            'down_count' => 'required'
        ]);


        // $this->authorize('update', $drive);
        $current_user = auth()->user();
        $drive = Drive::find($id);

        if ($current_user->id === $drive->user_id) {

            $drive->update($request->all() + ['user_id' => $current_user->id, 'slug' => Str::slug($request->name)]);

            return $drive;
        } else {
            return abort(401, 'you not own this drive to update!');
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
        $drive = Drive::find($id);

        if ($current_user->id === $drive->user_id) {
            $del = Drive::destroy($id);
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
            return abort(401, 'you not own this drive to delete!');
        }
    }
}
