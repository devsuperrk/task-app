<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'parent_id' => null,
            'status' => $this->faker->randomElement(['todo', 'in_progress', 'done']),
        ];
    }

    public function withParent(Task $parent)
    {
        return $this->state([
            'parent_id' => $parent->id,
        ]);
    }
}
