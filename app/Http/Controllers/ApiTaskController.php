<?php

namespace App\Http\Controllers;

// use App\Http\Requests\StoreTaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;



class ApiTaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::all();
        return response()->json([
            'status' => true,
            'tasks' => $tasks
        ], 200);    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $task = Task::create($request->all());
        // Log::debug($folder);
        return response()->json([
            'status' => true,
            'message' => 'Task Created successfully!',
            'task' => $task
        ], 201);    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTaskrequest $request)
    {
        $task = Task::create($request->all());
        // Log::debug($folder);
        return response()->json([
            'status' => true,
            'message' => 'Task Created successfully!',
            'task' => $task
        ], 201);    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(String $id)
    {
        $tasks = Task::find($id);
        if($tasks){
            return response()->json([
                'message'=> 'Task found',
                'data' => $tasks
            ], 200);
        } else {
            return response()->json([
                'message'=> 'Task not found',
            ], 404);
        }    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, String $id)
    {
        $update = [
            'title' => $request->title,
            // 'article' => $request->article
        ];
        $task =  Task::where('id', $id)->update($update);
        Log::debug($id);
        Log::debug($update);
        Log::debug($task);
        $tasks = Task::all();
        if ($task) {
            return response()->json([
                'message'=> 'Task update',
                'data' => $task
            ], 200);
        } else {
            return response()->json([
                'message' => 'Task not found',
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(String $id)
    {
        $task = Task::where('id', $id)->delete();
        if ($task) {
            return response()->json([
                'message' => 'Task deleted successfully',
            ], 200);
        } else {
            return response()->json([
                'message' => 'Task not found',
            ], 404);
        }    }
}
