<?php

namespace Database\Seeders;

use App\Helpers\UUIDGenerate;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Faker;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Str;
use Spatie\Activitylog\Contracts\Activity;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $featured = ['photo12@2x.jpg', 'photo14@2x.jpg', 'photo16@2x.jpg', 'photo18@2x.jpg', 'photo20@2x.jpg', 'photo17@2x.jpg', 'photo19@2x.jpg', 'photo21@2x.jpg'];
        $faker = Faker\Factory::create();
        for ($i = 1; $i <= 1000; $i++) {
            $title = $faker->text($maxNbChars = 20);
            $slug = Str::slug($title);
            $post = Post::create([
                'author_id' => random_int(2, 4),
                'type_id' => $faker->randomElement([1, 2, 3]),
                'title' => $title,
                'description' => $faker->text(),
                'slug' => UUIDGenerate::slug($slug),
                'content' => $faker->text($maxNbChars = 2000),
                'views' => random_int(1000, 2000),
                'published' => $faker->randomElement([true, false]),
                'created_at' => Date::now(),
                'updated_at' => Date::now(),
                'post_thumbnail' => $faker->randomElement($featured),
            ]);
            if ($post->type_id == 2) {
                $post->update([
                    'volume_id' => $faker->randomElement([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]),
                ]);
            }
            if ($post->type_id == 3) {
                $post->update([
                    'bulletin_id' => $faker->randomElement([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]),
                ]);
            }
            if ($post->published) {
                $post->update([
                    'published_at' => $faker->dateTimeThisYear(),
                ]);
            } else {
                $post->update([
                    'published_at' => null,
                ]);
            }
            activity()
                ->causedBy($post->author)
                ->performedOn($post)
                ->event('created')
                ->tap(function (Activity $activity) {
                    $activity->log_name = 'Default Post';
                })
                ->log($post->author->name . '  created the post');
        }
    }
}
