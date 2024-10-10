<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use \App\Models\Folder;
use \App\Http\Requests\CreateFolder;
use App\Http\Requests\EditFolder;

class FolderController extends Controller
{
    /**
     *  【フォルダ作成ページの表示機能】
     *
     *  GET /folders/create
     *  @return \Illuminate\View\View
     */

    public function showCreateForm()
    {

        try{
            $user = Auth::user();
            $user->folders;
            // return view('folders/create', compact('folders'));
            return view('folders/create');
        } catch(\Throwable $e){
            Log::error('Error FolderController in showCreateForm:' . $e->getMessage());
        }

    }


    /*
    * 【フォルダの作成機能】
    *
    *　POST /folders/create
    * @param Request $request(リクエストクラスの$request)
    * @return \Illuminate\Http\RedirectResponce
    * @var App\Http\Requests\CreateFolder
    */

    public function create(CreateFolder $request)
    {
        try{

            $folder = new Folder();
            $folder->title = $request->title;
            
            $user = Auth::user();
            $user->folders()->save($folder);
            // Auth::user()->folders()->save($folder);
        
            return redirect()->route('tasks.index', [
                'folder' => $folder->id,
            ]);
        } catch (\Exception $e) {
            Log::error('error FolderController in create:' . $e->getMessage());
        } 
    }

    /**
     *  【フォルダ編集ページの表示機能】
     *
     *  GET /folders/{id}/edit
     *  @param int $id
     *  @return \Illuminate\View\View
     */

    //  public function showEditForm(int $id)
    public function showEditForm(Folder $folder)
    {
        try {

            $user = Auth::user();
            $folder = $user->folders()->findOrFail($folder->id);
            
            return view('folders/edit',[
                'folder_id' => $folder->id,
                'folder_title' => $folder->title,
            ]);
        } catch(\Throwable $e){
            Log::error('Error FolderController in showEditForm: ' . $e->getMessage());     
        }
    }

    /**
     *  【フォルダの編集機能】
     *
     *  POST /folders/{id}/edit
     *  @param int $id
     *  @param EditTask $request
     *  @return \Illuminate\Http\RedirectResponse
     */
    // public function edit(int $id, EditFolder $request)
    public function edit(Folder $folder, EditFolder $request)
    {
        try {

            $user = Auth::user();
            $folder = $user->folders()->findOrFail($folder->id);
            $folder->title = $request->title;
            $folder->save();
            
            return redirect()->route('tasks.index', [
                'folder' => $folder->id,
            ]);
        } catch(\Throwable $e){
            Log::error('Error FolderController in edit: ' . $e->getMessage());
        }
    }


    /**
     *  【フォルダ削除ページの表示機能】
     *  機能：フォルダIDをフォルダ編集ページに渡して表示する
     *
     *  GET /folders/{id}/delete
     *  @param int $id
     *  @return \Illuminate\View\View
     */
    // public function showDeleteForm(int $id)
    public function showDeleteForm(Folder $folder)
    {
        try {

            $user = Auth::user();
            $folder = $user->folders()->findOrFail($folder->id);
        
            return view('folders/delete',[
                'folder_id' => $folder->id,
                'folder_title' => $folder->title,            
            ]);
        } catch (\Throwable $e){
            Log::error('Error in showDeleteForm: ' . $e->getMessage());
        }  
    }

    /**
     *  【フォルダの削除機能】
     *  機能：フォルダが削除されたらDBから削除し、フォルダ一覧にリダイレクトする
     *
     *  POST /folders/{id}/delete
     *  @param int $id
     *  @return RedirectResponse
     */
    // public function delete(int $id)
    public function delete(Folder $folder)
    {
        $user = Auth::user();
        $folder = $user->folders()->findOrFail($folder->id);
        
        $folder->tasks()->delete();
        $folder->delete();
        $folder = Folder::first();
        return redirect()->route('tasks.index', [
            'folder' => $folder->id,
        ]);
    }

    


}
