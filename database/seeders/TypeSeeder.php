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
            'name' => 'News/Article',
        ]);
        Type::create([
            'name' => 'NewsLetter',
        ]);
        Type::create([
            'name' => 'NewsBulletin',
        ]);
        Type::create([
            'name' => 'Podcast',
        ]);
        Type::create([
            'name' => 'Article',
        ]);
        Type::create([
            'name' => 'News',
        ]);
    }
}
