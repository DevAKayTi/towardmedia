<?php

namespace App\Jobs;

use App\Mail\SendPost;
use App\Models\Subscriber;
use App\Models\Post;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendPostEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $title;
    public $id;
    // public $imagePath;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        $title,
        $id,
        // $imagePath
        )
    {
        //
        $this->title = $title;
        $this->id = $id;
        // $this->imagePath = $imagePath;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
            // Retrieve activated subscribers' emails
            $activatedSubscribers = Subscriber::where('is_activated', 1)->pluck('email');

            // Retrieve the post
            $post = Post::findOrFail($this->id);
            $imagePath = 'storage/uploads/featured/' . $post->post_thumbnail;

            // Loop through activated subscribers and send emails
            foreach ($activatedSubscribers as $email) {
                Mail::to($email)->send(new SendPost(
                    $this->title,
                    $post->title,
                    $post->description,
                    $post->slug,
                    $imagePath,
                    $email
                ));
            }
    }
}
