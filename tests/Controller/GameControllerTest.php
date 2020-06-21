<?php

use App\Room;
use App\User;
use Illuminate\Http\Response;
use Tests\TestCase;

class GameControllerTest extends TestCase
{
    /**
     *
     */
    public function testShouldCreateCorrectGameRecords()
    {
        $user1 = User::find(1);
        $user2 = User::find(2);
        $user3 = User::find(3);
        $user4 = User::find(4);
//        $user1 = factory(User::class)->create();
//        $user2 = factory(User::class)->create();
//        $user3 = factory(User::class)->create();
//        $user4 = factory(User::class)->create();
//
//        $response = $this->apiAs($user1, 'post', '/api/room');
//        $actualData = json_decode($response->getContent(),true)['data'];
//        dump('room', $actualData);
//
//        $roomCode = $actualData['code'];
        $roomCode = '357065';
//        $res1 = $this->apiAs($user1, 'post', '/api/room/' . $roomCode . '/join');
//        $res1 = json_decode($res1->getContent(), true);
//        dump($res1);
//
//        $res2 = $this->apiAs($user2, 'post', '/api/room/' . $roomCode . '/join');
//        $res2 = json_decode($res2->getContent(), true);
//        dump($res2);
//
//        $res3 = $this->apiAs($user3, 'post', '/api/room/' . $roomCode . '/join');
//        $res3 = json_decode($res3->getContent(), true);
//        dump($res3);
//
//        $res4 = $this->apiAs($user4, 'post', '/api/room/' . $roomCode . '/join');
//        $res4 = json_decode($res4->getContent(), true);
//        dump($res4);
//
//
//        $res1 = $this->apiAs($user1, 'post', '/api/room/' . $roomCode . '/start');
//        $res1 = json_decode($res1->getContent(), true);
//        dump($res1);
//
//
//        $res1 = $this->apiAs($user1, 'get', '/api/room/' . $roomCode . '/user/initial-cards');
//        $res1 = json_decode($res1->getContent(), true);
//        dump($res1);
//
//        $res2 = $this->apiAs($user2, 'get', '/api/room/' . $roomCode . '/user/initial-cards');
//        $res2 = json_decode($res2->getContent(), true);
//        dump($res2);
//
//        $res3 = $this->apiAs($user3, 'get', '/api/room/' . $roomCode . '/user/initial-cards');
//        $res3 = json_decode($res3->getContent(), true);
//        dump($res3);
//
//        $res4 = $this->apiAs($user4, 'get', '/api/room/' . $roomCode . '/user/initial-cards');
//        $res4 = json_decode($res4->getContent(), true);
//        dump($res4);
//
//

        $res4 = $this->apiAs($user4, 'post', '/api/room/' . $roomCode . '/play', ['card' => '6D']);
        $res4 = json_decode($res4->getContent(), true);
        dump($res4);

    }
}
