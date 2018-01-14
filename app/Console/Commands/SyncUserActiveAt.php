<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class SyncUserActiveAt extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laravel:sync-user-active-at';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '将用户最后活跃时间从Redis同步的没有mysql';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(User $user)
    {
        $user->syncUserActiveAt();
        $this->info('同步成功');
    }
}
