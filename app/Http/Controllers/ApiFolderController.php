<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFolderRequest;
use App\Models\Folder;
use Illuminate\Http\Request;

class ApiFolderController extends Controller
{
    /**
     * Postmanでgetリクエスト送信時
     * @param  \App\Models\Folder  $folder
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $folders = Folder::all();
        return response()->json([
            'status' => true,
            'folders' => $folders
        ], 200);
    }
    
    
    /**
     * Postmanでpostリクエスト送信時
     * @param  \App\Models\Folder  $folder
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFolderRequest $request)
    {
        $folder = Folder::create($request->all());
        return response()->json([
            'status' => true,
            'message' => 'Folder Created successfully!',
            'folder' => $folder
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Folder  $folder
     * @return \Illuminate\Http\Response
     */
    public function show(Folder $id)
    {
        $folders = Folder::find($id);
        if($folders){
            return response()->json([
                'message'=> 'Folder found',
                'data' => $folders
            ], 200);
        } else {
            return response()->json([
                'message'=> 'Folder not found',
            ], 404);
        }
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Folder  $folder
     * @return \Illuminate\Http\Response
     */
    public function edit(Folder $folder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Folder  $folder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Folder $id)
    {
        $update = [
            'title' => $request->title,
            // 'article' => $request->article
        ];
        $folder =  Folder::where('id', $id)->update($update);
        $folders = Folder::all();
        if ($folder) {
            return response()->json([
                'message'=> 'Folder update',
                'data' => $folders
            ], 200);
        } else {
            return response()->json([
                'message' => 'Folder not found',
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Folder  $folder
     * @return \Illuminate\Http\Response
     */
    public function destroy(Folder $id)
    {
        $folder = Folder::where('id', $id)->delete();
        if ($folder) {
            return response()->json([
                'message' => 'Folder deleted successfully',
            ], 200);
        } else {
            return response()->json([
                'message' => 'Folder not found',
            ], 404);
        }
    }
}
