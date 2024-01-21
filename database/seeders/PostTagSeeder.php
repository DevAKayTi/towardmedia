<?php

namespace Database\Seeders;

use App\Models\PostCategory;
use App\Models\PostTag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        for ($i = 1; $i <= 100; $i++) {
            for ($j = 1; $j <= 2; $j++) {
                PostTag::create([
                    'post_id' => $i,
                    'tag_id' => random_int(1, 9),
                ]);
            }
        }
    }
}
