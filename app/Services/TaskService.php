<?php

namespace App\Services;

use App\Models\Task;
use App\Notifications\TaskRemainderNotification;
use App\Services\Interfaces\TaskInterface;

class TaskService implements TaskInterface
{

    /**
     * @inheritDoc
     */
    public function processNotifyInProgressTask()
    {
        $remainderTasks = $this->getNotDoneInProgressTask();
        foreach ($remainderTasks as $task) {
            $task->user->notify(new TaskRemainderNotification($task->title .' task is in progress for 24 hours'));
        }
    }

    private function getNotDoneInProgressTask()
    {
        $startDate = now()->subDay();
        $endDate = now();
        return Task::with(['user'])->where('status', Task::STATUS_IN_PROGRESS)
            ->whereBetween('updated_at', [$startDate, $endDate])
            ->limit(3)
            ->get();
    }
}
