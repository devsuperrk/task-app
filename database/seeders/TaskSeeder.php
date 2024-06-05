<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    public function run()
    {
        User::all()->each(function (User $user) {
            Task::factory()
                ->count(5)
                ->for($user)
                ->create()
                ->each(function (Task $task) {
                    Task::factory()
                        ->count(2)
                        ->withParent($task)
                        ->create([
                            'user_id' => $task->user_id,
                        ]);
                });
        });
    }
}
