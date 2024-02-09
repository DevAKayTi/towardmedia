<?php

namespace Database\Seeders;

use App\Models\Bulletin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker;
use Illuminate\Support\Facades\Date;
use Spatie\Activitylog\Models\Activity;

class BulletinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $faker = Faker\Factory::create();

        $bulletins = ['စာစဥ် ၁', 'စာစဥ် ၂', 'စာစဥ် ၃', 'စာစဥ် ၄', 'စာစဥ် ၅', 'စာစဥ် ၆', 'စာစဥ် ၇', 'စာစဥ် ၈', 'စာစဥ် ၉', 'စာစဥ် ၁၀', 'စာစဥ် ၁၁​', 'စာစဥ် ၁၂', 'စာစဥ် ၁၃', 'စာစဥ် ၁၄'];
        for ($i = 0; $i < count($bulletins); $i++) {
            $bulletin =  Bulletin::create([
                'title' => $bulletins[$i],
                'author_id' => $faker->randomElement([2, 3, 4]),
                'published' => 1,
                'published_at' => Date::now(),
            ]);
            activity()
                ->causedBy($bulletin->author)
                ->performedOn($bulletin)
                ->event('created')
                ->tap(function (Activity $activity) {
                    $activity->log_name = 'Default Bulletin';
                })
                ->log($bulletin->author->name . '  created the Bulletin');
        }
    }
}
