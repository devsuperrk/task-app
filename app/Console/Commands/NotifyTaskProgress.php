<?php

namespace App\Console\Commands;

use App\Services\Interfaces\TaskInterface;
use Illuminate\Console\Command;

class NotifyTaskProgress extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:notify-task-progress';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Will notify users for in progress tasks that not done in 24 hours';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Notifying users for in progress tasks that not done in 24 hours');
        app(TaskInterface::class)->processNotifyInProgressTask();
        $this->info('Notified users for in progress tasks that not done in 24 hours');
    }
}
