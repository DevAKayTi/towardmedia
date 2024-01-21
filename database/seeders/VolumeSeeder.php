<?php

namespace Database\Seeders;

use App\Models\Volume;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker;
use Illuminate\Support\Facades\Date;
use Spatie\Activitylog\Models\Activity;

class VolumeSeeder extends Seeder
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

        $volumes = ['စာစဥ် ၁', 'စာစဥ် ၂', 'စာစဥ် ၃', 'စာစဥ် ၄', 'စာစဥ် ၅', 'စာစဥ် ၆', 'စာစဥ် ၇', 'စာစဥ် ၈', 'စာစဥ် ၉', 'စာစဥ် ၁၀', 'စာစဥ် ၁၁​', 'စာစဥ် ၁၂', 'စာစဥ် ၁၃', 'စာစဥ် ၁၄'];
        for ($i = 0; $i < count($volumes); $i++) {
            $volume =  Volume::create([
                'title' => $volumes[$i],
                'author_id' => $faker->randomElement([2, 3, 4]),
                'published' => 1,
                'published_at' => Date::now(),
            ]);
            activity()
                ->causedBy($volume->author)
                ->performedOn($volume)
                ->event('created')
                ->tap(function (Activity $activity) {
                    $activity->log_name = 'Default Volume';
                })
                ->log($volume->author->name . '  created the Volume');
        }
    }
}
