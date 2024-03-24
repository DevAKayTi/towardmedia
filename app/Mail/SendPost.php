<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendPost extends Mailable
{
    use Queueable, SerializesModels;

    public $title;
    public $postTitle;
    public $description;
    public $slug;
    public $imagePath;
    public $email;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(
        $title,
        $postTitle,
        $description,
        $slug,
        $imagePath,
        $email
        )
    {
        $this->title = $title;
        $this->postTitle = $postTitle;
        $this->description = $description;
        $this->slug = $slug;
        $this->imagePath = $imagePath;
        $this->email = $email;
        //
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: $this->title,
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'emails.newRelease',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
