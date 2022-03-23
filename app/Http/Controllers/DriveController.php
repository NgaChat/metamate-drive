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
        
        // $this->authorize('isUser', Drive::class);
        $offset = request('offset') ?: '0';
        $limit = request('limit') ?: '30';
        $id = $request->header('id');
        $drives = Drive::where('user_id', $id)->offset($offset)->limit($limit)->latest()->get();
        return $drives;
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
            'user_id' => 'required',
            'file_id' => 'required',
            'file_size' => 'required',
            'mime_type' => 'required',
            'thumb' => 'required',
            'down_count' => 'required'
        ]);

        $request['slug'] = Str::slug($request->name);


        return Drive::create($request->all());
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
    public function update(Request $request, $id, Drive $drive)
    {
        $this->authorize('update', $drive);
        $drive = Drive::find($id);
        $drive->update($request->all());
        return $drive;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
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
    }
}
