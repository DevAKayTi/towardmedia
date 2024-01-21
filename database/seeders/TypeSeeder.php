<?php

namespace Database\Seeders;

use App\Models\Type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Type::create([
            'name' => 'News',
        ]);
        Type::create([
            'name' => 'Article',
        ]);
        Type::create([
            'name' => 'Podcast',
        ]);
    }
}
