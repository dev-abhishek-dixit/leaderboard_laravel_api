<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

/**
 * ResetUsersPoint
 * 
 * @package    App\Commands
 * @subpackage Commands
 * @author     Abhishek Dixit<abhishekdixit342@gmail.com> 
 */

class ResetUsersPoint extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:reset-users-point';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset Users points to 0';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::query()->update(['points' => 0]);
        $this->info('All users points have been reset to 0.');
    }
}
