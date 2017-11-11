<?php

namespace App\Mail;

use App\Models\Article;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DailyStory extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * @var Article
     */
    public $article;

    /**
     * Create a new message instance.
     *
     * @param Article $article
     */
    public function __construct(Article $article)
    {
        $this->article = $article;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->subject(trans('email.daily.subject'));

        $this->markdown('emails.news.daily');

        return $this;
    }
}
