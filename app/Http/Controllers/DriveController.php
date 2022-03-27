<?php

namespace App\Http\Controllers;

use App\Models\Drive;
use App\Models\Ads;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DriveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // $offset = request('offset') ?: '0';
        // $limit = request('limit') ?: '30';
        // $id = $request->header('id');
        // $drives = Drive::where('user_id', $id)->offset($offset)->limit($limit)->latest()->get();
        // return $drives;
        $drives = Drive::where('user_id', auth()->user()->id)->latest('created_at')->paginate(10);
        return response()->json($drives, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $drive = Drive::create($this->validateDrive() + ['user_id' => $request->user()->id, 'slug' => str()->slug($request->name)]);

        return response()->json($drive, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug, Drive $drive)
    {
        $drive_data = $drive->where('slug', $slug)->first();

        $ads = Ads::where('user_id', $drive_data->user_id)->first();

        $response = [
            'drive' => $drive_data,
            'ads' => $ads
        ];

        return $response;
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
        $current_user = auth()->user();
        $drive = Drive::find($id);

        if ($current_user->id === $drive->user_id) {

            $drive->update($this->validateDrive() + ['user_id' => $current_user->id, 'slug' => Str::slug($request->name)]);

            return $drive;
        } else {
            return abort(401, 'you not own this drive to update!');
        }
    }

    public function update_down_count($id)
    {
        $drive = Drive::find($id);

        return $drive->update(['down_count' => request()->down_count]);
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

    public function validateDrive()
    {
        return request()->validate([
            'name' => 'required',
            'file_id' => 'required',
            'file_size' => 'required',
            'mime_type' => 'required',
            'thumb' => 'required',
        ]);
    }
}
