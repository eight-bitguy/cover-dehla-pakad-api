<?php

namespace App\Events;

use App\Http\Transformers\RoomTransformer;
use App\Room;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;

class BroadcastRoomStartEvent implements ShouldBroadcast
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
        $this->room = $room;
        $this->fractalManager = new Manager();
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
        $room = new Item($this->room, new RoomTransformer());
        return $this->fractalManager->createData($room)->toArray();
    }
}
