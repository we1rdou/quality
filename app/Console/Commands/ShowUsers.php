<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class ShowUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:show';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Show all users with their roles';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::all(['name', 'email', 'role']);

        $this->table(
            ['Name', 'Email', 'Role'],
            $users->map(function ($user) {
                return [
                    $user->name,
                    $user->email,
                    $user->role,
                ];
            })
        );

        $this->info('Total users: '.$users->count());
    }
}
