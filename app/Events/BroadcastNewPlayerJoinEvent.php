<?php

namespace App\Events;

use App\Http\Transformers\UserTransformer;
use App\Room;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;

class BroadcastNewPlayerJoinEvent implements ShouldBroadcast
{
    use Dispatchable;

    private $room;
    private $fractalManager;

    /**
     * Create a new event instance.
     *
     * @param Room $room
     */
    public function __construct(Room $room)
    {
        $room->load('users');
        $this->room = $room;
        $this->fractalManager = new Manager();
        $this->fractalManager->parseIncludes(['room_users']);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return PrivateChannel
     */
    public function broadcastOn()
    {
        return new PrivateChannel("App.room.{$this->room->code}");
    }

    public function broadcastWith()
    {
        $users = new Collection($this->room->users, new UserTransformer($this->room->code));
        return $this->fractalManager->createData($users)->toArray();
    }
}
