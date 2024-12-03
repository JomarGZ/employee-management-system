<?php

namespace App\Events;

use App\Models\Export;
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
    public int $tries = 3;
    public int $backoff = 3;

    protected Export $exportedData;
    protected string $message;
    /**
     * Create a new event instance.
     */
    public function __construct(User $user, Export $exportedData)
    {
        $this->user = $user;
        $this->exportedData = $exportedData;

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
            'exportedData' => $this->exportedData ?? null,
        ];
    }
}
