<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker;
use Illuminate\Support\Facades\Hash;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'role' => 2, //2 for super admin
            'password' => Hash::make('adminadmin'),
            'status' => '1',
        ]);
        for ($i = 1; $i <= 3; $i++) {
            User::create([
                'name' => 'Author' . $i,
                'email' => 'author' . $i . '@gmail.com',
                'role' => 1, //1 for normal admin
                'password' => Hash::make('adminadmin'),
                'status' => '1',
            ]);
        }
    }
}
