<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Folder;
use App\Models\Task;
use App\Http\Requests\CreateTask;
use App\Http\Requests\EditTask;

class TaskController extends Controller
{
    /**
     *  【タスク一覧ページの表示機能】
     *
     *  GET /folders/{id}/tasks
     *  @param int $id
     *  @return \Illuminate\View\View
     */
    
    // public function index(int $id)
    public function index(Folder $folder)
    {

        // abort(500);
        // $folders = Folder::all();
        // $folder = Folder::find($id);
        try {

            $user = auth()->user();
            $folders = $user->folders()->get();
            $tasks = $folder->tasks()->get();
            
            
            
            
            if(is_null($folder)){
            abort(404);
        }

        // if(Auth::user()->id !== $folder->use_id){
            //     abort(403);
        // }


        
        
        // $tasks = $folder->tasks()->get();
        // $tasks = Task::where('folder_id', $folder->id)->get();
        
            return view('tasks/index', [
                'folders' => $folders,
                "folder_id" => $folder->id,
                // "folder_id" => $id,
                'tasks' => $tasks,
            ]);
        } catch(\Throwable $e){
            Log::error('Error FolderController in index: ' . $e->getMessage());
        }
    }
    
    /*
    *  【タスク作成ページの表示機能】
    *　
    *   GET /folders/{id}/tasks/create
    *   @param int $id
    *   @return \Illuminate\View\View
    *
    */
    public function showCreateForm(Folder $folder)
    {
        try {

            $user = Auth::user();
            $folder = $user->folders()->findOrFail($folder->id);
            
            return view('tasks/create', [
                'folder_id' => $folder->id,
            ]);
        } catch (\Throwable $e){
            Log::error('Error FolderController in showCreateForm: ' . $e->getMessage());
        }
    }

    /**
     *  【タスクの作成機能】
     *
     *  POST /folders/{id}/tasks/create
     *  @param int $id
     *  @param CreateTask $request
     *  @return \Illuminate\Http\RedirectResponse
     */
    public function create(Folder $folder, CreateTask $request)
    {
        try {

            $user = Auth::user();
            $folder = $user->folders()->findOrFail($folder->id);
                
            $task = new Task();
            $task->title = $request->title;
            $task->due_date = $request->due_date;
            $folder->tasks()->save($task);
            
            return redirect()->route('tasks.index', [
                'folder' => $folder->id,
            ]);
        }  catch (\Throwable $e){
            Log::error('Error TaskController in create: ' . $e->getMessage());
        }
    }

    /**
     *  【タスク編集ページの表示機能】
     *  機能：タスクIDをフォルダ編集ページに渡して表示する
     *  
     *  GET /folders/{id}/tasks/{task_id}/edit
     *  @param int $id
     *  @param int $task_id
     *  @return \Illuminate\View\View
     */    

    public function showEditForm(Folder $folder, Task $task)
    {
        try {

            $this->checkRelation($folder, $task);
            // if($folder->id !== $task->folder_id){
                //     abort(404);
                // }
                
        
                
            /** @var App\Models\User **/
            $user = Auth::user();
            $folder = $user->folders()->findOrFail($folder->id);
            $task->find($task->id);
            // $task = $folder->tasks()->find($task->id);
            
            return view('tasks/edit', [
                'task' => $task,
            ]);
        } catch (\Throwable $e){
            Log::error('Error TaskController in showEditForm: ' . $e->getMessage());
        }
    }
    
    /**
     *  【タスクの編集機能】
     *  機能：タスクが編集されたらDBを更新処理をしてタスク一覧にリダイレクトする
     *  
     *  POST /folders/{id}/tasks/{task_id}/edit
     *  @param int $id
     *  @param int $task_id
     *  @param EditTask $request
     *  @return \Illuminate\Http\RedirectResponse
     */
    
    public function edit(Folder $folder, Task $task, EditTask $request)
    {
        try {

            $this->checkRelation($folder, $task);
            
            //  if($folder->id !== $task->folder_id){
                //      abort(404);
        //  }


        $user = Auth::user();
        $folder = $user->folders()->findOrFail($folder->id);
        $task->find($task->id);
        // $task = $folder->tasks()->find($task->id);
        
        $task->title = $request->title;
        $task->status = $request->status;
        $task->due_date = $request->due_date;
        $task->save();
        
        return redirect()->route('tasks.index', [
            'folder' => $task->folder_id,
        ]);
        }catch (\Throwable $e){
            Log::error('Error TaskController in edit: ' . $e->getMessage());
        }
    }

    private function checkRelation(Folder $folder, Task $task)
    {
        if ($folder->id !== $task->folder_id) {
            abort(404);
        }
    }
    

    /**
     *  【タスク削除ページの表示機能】
     *
     *  GET /folders/{id}/tasks/{task_id}/delete
     *  @param int $id
     *  @param int $task_id
     *  @return \Illuminate\View\View
     */
    public function showDeleteForm(Folder $folder, Task $task)
    {
        try {

            $this->checkRelation($folder, $task);
            $user = Auth::user();
            $folder = $user->folders()->findOrFail($folder->id);
            $task->find($task->id);
            // $task = $folder->tasks()->find($task->id);
        
            return view('tasks/delete', [
                'task' => $task,
            ]);
        }catch (\Throwable $e){
                Log::error('Error TaskController in showDeleteForm: ' . $e->getMessage());
        }
    }
    
    /**
     *  【タスクの削除機能】
     *
     *  POST /folders/{id}/tasks/{task_id}/delete
     *  @param int $id
     *  @param int $task_id
     *  @return \Illuminate\View\View
     */
    public function delete(Folder $folder, Task $task)
    {
        try {

            $this->checkRelation($folder, $task);
            $user = Auth::user();
            $folder = $user->folders()->findOrFail($folder->id);
            $task->find($task->id);
            // $task = $folder->tasks()->findOrFail($task->id);
            
            $task->delete();
            
            return redirect()->route('tasks.index', [
                'folder' => $task->folder_id,
            ]);
        } catch (\Throwable $e){
            Log::error('Error TaskController in delete: ' . $e->getMessage());
        }
    }



}
