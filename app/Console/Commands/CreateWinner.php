<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

/**
 * CreateWinner
 * 
 * @package    App\Commands
 * @subpackage Commands
 * @author     Abhishek Dixit<abhishekdixit342@gmail.com> 
 */

class CreateWinner extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-winner';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new winner';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::select('id', 'points')
            ->orderBy('points', 'desc')
            ->take(2)->get();
        if ($users->count()==0) {
            $this->info('No users found.');
            return ;
        }
        if ($users->count() == 1) {
              $users[0]->winner()->create([
                'winner_points' => $users[0]->points,
              ]);
              $this->info('Winner created successfully for user ID: ' . $users[0]->id . ' with points: ' . $users[0]->points);
              return ;
        } 
        if ($users[0]->points > $users[1]->points){
            /**
             * i may update only timestamp of the winner if it exists with same 
             * user_id and points but currently i am creating a new winner
             */
            $users[0]->winner()->create([
                'winner_points' => $users[0]->points,
            ]);
            $this->info('Winner created successfully for user ID: ' . $users[0]->id . ' with points: ' . $users[0]->points);
        }
        
    }
}
