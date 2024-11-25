<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;

class ExportCsvStatusUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    protected User $user;
    protected string $message;
    protected $link;
    /**
     * Create a new event instance.
     */
    public function __construct(User $user, array $payload)
    {
        $this->user = $user;
        $this->message = Arr::pull($payload, 'message');

        if (isset($payload['link'])) {
            $this->link = Arr::pull($payload, 'link');
        }
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel("App.Models.User.{$this->user->id}"),
        ];
    }

    public function broadCastWith()
    {
        return [
            'message' => $this->message
        ];
    }
}
