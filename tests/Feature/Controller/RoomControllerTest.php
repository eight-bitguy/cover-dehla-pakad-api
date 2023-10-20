<?php

use App\Room;
use App\User;
use Illuminate\Http\Response;
use Tests\TestCase;

class RoomControllerTest extends TestCase
{

    // public function testShouldCreateANewRoomWithCorrectAttributes()
    // {
    //     $initialRoomCount = Room::count();
    //     $user = factory(User::class)->create();

    //     $response = $this->apiAs($user, 'post', '/api/room');
    //     $actualData = json_decode($response->getContent(),true)['data'];

    //     $roomCount = Room::count();
    //     $room = Room::whereCode($actualData['code'])->first();
    //     $expectedData = [
    //         'status' => Room::ROOM_STATUS_JOINING,
    //         'code' => $room->code
    //     ];

    //     $this->assertEquals(Response::HTTP_OK, $response->getStatusCode(), 'Mismatch of status code');
    //     $this->assertEquals(1, $roomCount - $initialRoomCount, 'Room not created in Database');
    //     $this->assertEquals($expectedData, $actualData, 'Wrong room attributes');
    //     $this->assertEquals(Room::ROOM_STATUS_JOINING, $room->status, 'wrong room status');
    // }
}
