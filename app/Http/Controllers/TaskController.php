<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $tasks = $request->user()->tasks()->get();
        if ($tasks->isEmpty()) {
            return response()->json([
                'message' => 'No task found'
            ]);
        }
        return response()->json([
            'tasks' => $tasks
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validate = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'string|max:255',
            'status' => 'in:pending,completed'
        ]);
        $request->user()->tasks()->create($validate);
        return response()->json([
            'status' => 'true',
            'message' => "Task created Successfully"
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
        $this->authorizeTask($task);
        return response()->json($task);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        //
        $this->authorizeTask($task);
        $validate = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'string|max:255',
            'status' => 'in:pending,completed'
        ]);
        $task->update($validate);
        return response()->json([
            'status' => 'true',
            'message' => "Task updated Successfully"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        //
        $this->authorizeTask($task);
        $task->delete();
        return response()->json([
            'status' => true,
            'message' => 'Task deleted successfully'
        ]);
    }
    private function authorizeTask(Task $task)
    {
        if ($task->user_id != auth()->id()) {
            abort('403', 'Unauthorized');
        }
    }
}
