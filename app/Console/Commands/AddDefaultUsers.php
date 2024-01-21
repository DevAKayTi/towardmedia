<?php

namespace App\Console\Commands;

use App\Enums\UserStatusType;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class AddDefaultUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Insert default user for this project';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'role' => 2, //2 for super admin
            'password' => Hash::make('adminadmin'),
            'status' => UserStatusType::Active,
        ]);
        for ($i = 1; $i <= 3; $i++) {
            User::create([
                'name' => 'Author' . $i,
                'email' => 'author' . $i . '@gmail.com',
                'role' => 1, //1 for normal admin
                'password' => Hash::make('adminadmin'),
                'status' => UserStatusType::Active,

            ]);
        }
        return 'Successfully created the project';
    }
}
