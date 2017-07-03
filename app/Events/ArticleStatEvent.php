<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Article;
use App\Stat;
class ArticleStatEvent
{
    use InteractsWithSockets, SerializesModels;
    public $event;
    public $id;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($event, $article)
    {
        if ($event === 'view') {
            // dd($article);
            $article->stat->view += 1;
            $article->save();
        }
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        // return new PrivateChannel('channel-name');
    }
}
