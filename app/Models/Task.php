<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends Model
{
    use HasFactory;

    protected $guarded = [];

    const STATUS_TODO = 'todo';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_DONE = 'done';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parent()
    {
        return $this->belongsTo(Task::class, 'parent_id');
    }

    public function sub_tasks(): HasMany
    {
        return $this->hasMany(Task::class, 'parent_id')->with('sub_tasks');
    }
}
