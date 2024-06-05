<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $userId = $request->user()->id;
        $totalTodoTask = Task::where('status', Task::STATUS_TODO)->where('user_id', $userId)->count();
        $totalProcessingTask = Task::where('status', Task::STATUS_IN_PROGRESS)->where('user_id', $userId)->count();
        $totalDoneTask = Task::where('status', Task::STATUS_DONE)->where('user_id', $userId)->count();
        return Inertia::render('Dashboard', [
                'stats' => [
                    'totalTodoTask' => $totalTodoTask,
                    'totalProcessingTask' => $totalProcessingTask,
                    'totalDoneTask' => $totalDoneTask,
                ]
            ]
        );
    }
}
