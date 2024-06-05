<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskStoreRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            return $this->list($request);
        }
        return Inertia::render('Task');
    }

    public function list(Request $request)
    {
        $tasks = Task::with('sub_tasks')->where('user_id', $request->user()->id)->whereNull('parent_id')->latest()->paginate();
        return response()->json($tasks);
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
    public function store(TaskStoreRequest $request)
    {
        $validated = $request->validated();
//        dd($validated);
        $validated['user_id'] = $request->user()->id;
        Task::create($validated);
//        return response()->json(['message' => 'Task created successfully.']);
        return redirect()->back()->with('success', 'Task created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function update(UpdateTaskRequest $request, string $id)
    {
        $task = Task::findOrFail($id);
        $validated = $request->validated();
        $task->update($validated);

        return redirect()->back()->with('success', 'Task updated successfully.');
    }

    public function destroy($taskId)
    {
        $task = Task::findOrFail($taskId);
        $task->delete();

        return redirect()->back()->with('success', 'Task deleted successfully.');
    }
}
