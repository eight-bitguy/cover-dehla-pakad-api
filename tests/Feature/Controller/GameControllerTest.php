<?php

use App\Room;
use App\User;
use App\Game;
use Illuminate\Http\Response;
use Tests\TestCase;

class GameControllerTest extends TestCase
{
    /**
     *
     */
    // public function testShouldCreateCorrectGameRecords()
    // {
    //     $user1 = factory(User::class)->create();
    //     $user2 = factory(User::class)->create();
    //     $user3 = factory(User::class)->create();
    //     $user4 = factory(User::class)->create();

    //     $response = $this->apiAs($user1, 'post', '/api/room');
    //     $actualData = json_decode($response->getContent(),true)['data'];

    //     $roomCode = $actualData['code'];
    //     $room = Room::whereCode($roomCode)->first();
        
    //     $res1 = $this->apiAs($user1, 'post', '/api/room/' . $roomCode . '/join');
    //     $res1 = json_decode($res1->getContent(), true);

    //     $res2 = $this->apiAs($user2, 'post', '/api/room/' . $roomCode . '/join');
    //     $res2 = json_decode($res2->getContent(), true);

    //     $res3 = $this->apiAs($user3, 'post', '/api/room/' . $roomCode . '/join');
    //     $res3 = json_decode($res3->getContent(), true);

    //     $res4 = $this->apiAs($user4, 'post', '/api/room/' . $roomCode . '/join');
    //     $res4 = json_decode($res4->getContent(), true);

    //     $res1 = $this->apiAs($user1, 'post', '/api/room/' . $roomCode . '/start');
    //     $res1 = json_decode($res1->getContent(), true);

    //     $res1 = $this->apiAs($user1, 'get', '/api/room/' . $roomCode . '/user/initial-cards');
    //     $res1 = json_decode($res1->getContent(), true);

    //     $res2 = $this->apiAs($user2, 'get', '/api/room/' . $roomCode . '/user/initial-cards');
    //     $res2 = json_decode($res2->getContent(), true);

    //     $res3 = $this->apiAs($user3, 'get', '/api/room/' . $roomCode . '/user/initial-cards');
    //     $res3 = json_decode($res3->getContent(), true);

    //     $res4 = $this->apiAs($user4, 'get', '/api/room/' . $roomCode . '/user/initial-cards');
    //     $res4 = json_decode($res4->getContent(), true);

    //     $game = $room->getLatestGame();

    //     $this->assertEquals(12, count($game->a1), 'A1 should have 12 cards');
    //     $this->assertEquals(13, count($game->a2), 'A2 should have 13 cards');
    //     $this->assertEquals(13, count($game->b1), 'B1 should have 13 cards');
    //     $this->assertEquals(13, count($game->b2), 'B2 should have 13 cards');
        
    //     $a1 = ["7S", "9S", "AS", "2H", "4H", "7H", "JH", "QH", "7D", "TD", "4C", "TC"];
    //     $a2 = ["5S", "TS", "QS", "3H", "6H", "8H", "2D", "9D", "JD", "2C", "7C", "KC", "AC"];
    //     $b1 = ["3S", "4S", "8S", "KS", "5H", "KH", "3D", "4D", "8D", "QD", "AD", "5C", "QC"];
    //     $b2 = ["2S", "6S", "JS", "9H", "TH", "AH", "5D", "6D", "KD", "3C", "6C", "8C", "9C"];

    //     $game->a1 = $a1;
    //     $game->a2 = $a2;
    //     $game->b1 = $b1;
    //     $game->b2 = $b2;
    //     $game->trump = 'JC';

    //     $game->save();

    //     $card = 'AS';
    //     $handDeck = $a1;
    //     $playBy = $user1;
    //     $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
    //     $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
    //     $handDeck = array_diff($handDeck, [$card]);
    //     $stake = [$card];
    //     $game = $room->getLatestGame();
    //     $this->assertEquals(array_values($game->a1), array_values($handDeck), 'Mismatch of hand deck');
    //     $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
    //     dump("{$card} - Done");
    //     $a1 = $handDeck;
        

    //     $card = '3S';
    //     $handDeck = $b1;
    //     $playBy = $user2;
    //     $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
    //     $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
    //     $handDeck = array_diff($handDeck, [$card]);
    //     $stake = array_merge($stake, [$card]);
    //     $game = $room->getLatestGame();
    //     $this->assertEquals(array_values($game->b1), array_values($handDeck), 'Mismatch of hand deck');
    //     $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
    //     dump("{$card} - Done");
    //     $b1 = $handDeck;


        
    //     $card = 'TS';
    //     $handDeck = $a2;
    //     $playBy = $user3;
    //     $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
    //     $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
    //     $handDeck = array_diff($handDeck, [$card]);
    //     $stake = array_merge($stake, [$card]);
    //     $game = $room->getLatestGame();
    //     $this->assertEquals(array_values($game->a2), array_values($handDeck), 'Mismatch of hand deck');
    //     $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
    //     dump("{$card} - Done");
    //     $a2 = $handDeck;


    //     $card = '2S';
    //     $handDeck = $b2;
    //     $playBy = $user4;
    //     $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
    //     $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
    //     $handDeck = array_diff($handDeck, [$card]);
    //     $stake = [];
    //     $game = $room->getLatestGame();
    //     $this->assertEquals(array_values($game->b2), array_values($handDeck), 'Mismatch of hand deck');
    //     $this->assertEquals('S', $game->dehla_score["a1"], 'Mismatch of score');
    //     $this->assertEquals('a1', $game->next_chance, 'Mismatch of score');
    //     $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
    //     dump("{$card} - Done");
    //     $b2 = $handDeck;


    //     $card = '9S';
    //     $handDeck = $a1;
    //     $playBy = $user1;
    //     $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
    //     $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
    //     $handDeck = array_diff($handDeck, [$card]);
    //     $stake = array_merge($stake, [$card]);
    //     $game = $room->getLatestGame();
    //     $this->assertEquals(array_values($game->a1), array_values($handDeck), 'Mismatch of hand deck');
    //     $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
    //     dump("{$card} - Done");
    //     $a1 = $handDeck;

    //     $card = '4S';
    //     $handDeck = $b1;
    //     $playBy = $user2;
    //     $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
    //     $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
    //     $handDeck = array_diff($handDeck, [$card]);
    //     $stake = array_merge($stake, [$card]);
    //     $game = $room->getLatestGame();
    //     $this->assertEquals(array_values($game->b1), array_values($handDeck), 'Mismatch of hand deck');
    //     $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
    //     dump("{$card} - Done");
    //     $b1 = $handDeck;


    //     $card = 'QS';
    //     $handDeck = $a2;
    //     $playBy = $user3;
    //     $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
    //     $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
    //     $handDeck = array_diff($handDeck, [$card]);
    //     $stake = array_merge($stake, [$card]);
    //     $game = $room->getLatestGame();
    //     $this->assertEquals(array_values($game->a2), array_values($handDeck), 'Mismatch of hand deck');
    //     $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
    //     dump("{$card} - Done");
    //     $a2 = $handDeck;

    //     $card = '6S';
    //     $handDeck = $b2;
    //     $playBy = $user4;
    //     $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
    //     $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
    //     $handDeck = array_diff($handDeck, [$card]);
    //     $stake = [];
    //     $game = $room->getLatestGame();
    //     $this->assertEquals(array_values($game->b2), array_values($handDeck), 'Mismatch of hand deck');
    //     $this->assertEquals('S', $game->dehla_score["a1"], 'Mismatch of score');
    //     $this->assertEquals(1, $game->score["a2"], 'Mismatch of score');
    //     $this->assertEquals('a2', $game->next_chance, 'Mismatch of next chance');
    //     $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
    //     dump("{$card} - Done");
    //     $b2 = $handDeck;

    //     // $a1 = ["7S", "2H", "4H", "7H", "JH", "QH", "7D", "TD", "4C", "TC"];
    //     // $a2 = ["5S", "3H", "6H", "8H", "2D", "9D", "JD", "2C", "7C", "KC", "AC"];
    //     // $b1 = ["8S", "KS", "5H", "KH", "3D", "4D", "8D", "QD", "AD", "5C", "QC"];
    //     // $b2 = ["JS", "9H", "TH", "AH", "5D", "6D", "KD", "3C", "6C", "8C", "9C"];


    //     $card = '5S';
    //     $handDeck = $a2;
    //     $playBy = $user3;
    //     $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
    //     $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
    //     $handDeck = array_diff($handDeck, [$card]);
    //     $stake = array_merge($stake, [$card]);
    //     $game = $room->getLatestGame();
    //     $this->assertEquals(array_values($game->a2), array_values($handDeck), 'Mismatch of hand deck');
    //     $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
    //     dump("{$card} - Done");
    //     $a2 = $handDeck;

    //     $card = 'JS';
    //     $handDeck = $b2;
    //     $playBy = $user4;
    //     $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
    //     $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
    //     $handDeck = array_diff($handDeck, [$card]);
    //     $stake = array_merge($stake, [$card]);
    //     $game = $room->getLatestGame();
    //     $this->assertEquals(array_values($game->b2), array_values($handDeck), 'Mismatch of hand deck');
    //     $this->assertEquals('S', $game->dehla_score["a1"], 'Mismatch of score');
    //     $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
    //     dump("{$card} - Done");
    //     $b2 = $handDeck;

    //     $card = '7S';
    //     $handDeck = $a1;
    //     $playBy = $user1;
    //     $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
    //     $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
    //     $handDeck = array_diff($handDeck, [$card]);
    //     $stake = array_merge($stake, [$card]);
    //     $game = $room->getLatestGame();
    //     $this->assertEquals(array_values($game->a1), array_values($handDeck), 'Mismatch of hand deck');
    //     $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
    //     dump("{$card} - Done");
    //     $a1 = $handDeck;

    //     $card = '8S';
    //     $handDeck = $b1;
    //     $playBy = $user2;
    //     $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
    //     $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
    //     $handDeck = array_diff($handDeck, [$card]);
    //     $stake = [];
    //     $game = $room->getLatestGame();
    //     $this->assertEquals(array_values($game->b1), array_values($handDeck), 'Mismatch of hand deck');
    //     $this->assertEquals('b2', $game->next_chance, 'Mismatch of next chance');
    //     $this->assertEquals(1, $game->score["b2"], 'Mismatch of score');
    //     $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
    //     dump("{$card} - Done");
    //     $b1 = $handDeck;


    //     // $a1 = ["2H", "4H", "7H", "JH", "QH", "7D", "TD", "4C", "TC"];
    //     // $a2 = ["3H", "6H", "8H", "2D", "9D", "JD", "2C", "7C", "KC", "AC"];
    //     // $b1 = ["KS", "5H", "KH", "3D", "4D", "8D", "QD", "AD", "5C", "QC"];
    //     // $b2 = ["9H", "TH", "AH", "5D", "6D", "KD", "3C", "6C", "8C", "9C"];


    //     $card = 'AH';
    //     $handDeck = $b2;
    //     $playBy = $user4;
    //     $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
    //     $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
    //     $handDeck = array_diff($handDeck, [$card]);
    //     $stake = array_merge($stake, [$card]);
    //     $game = $room->getLatestGame();
    //     $this->assertEquals(array_values($game->b2), array_values($handDeck), 'Mismatch of hand deck');
    //     $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
    //     dump("{$card} - Done");
    //     $b2 = $handDeck;

    //     $card = '7H';
    //     $handDeck = $a1;
    //     $playBy = $user1;
    //     $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
    //     $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
    //     $handDeck = array_diff($handDeck, [$card]);
    //     $stake = array_merge($stake, [$card]);
    //     $game = $room->getLatestGame();
    //     $this->assertEquals(array_values($game->a1), array_values($handDeck), 'Mismatch of hand deck');
    //     $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
    //     dump("{$card} - Done");
    //     $a1 = $handDeck;

    //     $card = 'KH';
    //     $handDeck = $b1;
    //     $playBy = $user2;
    //     $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
    //     $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
    //     $handDeck = array_diff($handDeck, [$card]);
    //     $stake = array_merge($stake, [$card]);
    //     $game = $room->getLatestGame();
    //     $this->assertEquals(array_values($game->b1), array_values($handDeck), 'Mismatch of hand deck');
    //     $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
    //     dump("{$card} - Done");
    //     $b1 = $handDeck;

    //     $card = '8H';
    //     $handDeck = $a2;
    //     $playBy = $user3;
    //     $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
    //     $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
    //     $handDeck = array_diff($handDeck, [$card]);
    //     $stake = [];
    //     $game = $room->getLatestGame();
    //     $this->assertEquals(array_values($game->a2), array_values($handDeck), 'Mismatch of hand deck');
    //     $this->assertEquals(2, $game->score["b2"], 'Mismatch of score');
    //     $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
    //     $this->assertEquals('b2', $game->next_chance, 'Mismatch of next chance');
    //     dump("{$card} - Done");
    //     $a2 = $handDeck;

    //     // $a1 = ["2H", "4H", "JH", "QH", "7D", "TD", "4C", "TC"];
    //     // $a2 = ["3H", "6H", "2D", "9D", "JD", "2C", "7C", "KC", "AC"];
    //     // $b1 = ["KS", "5H", "3D", "4D", "8D", "QD", "AD", "5C", "QC"];
    //     // $b2 = ["9H", "TH", "5D", "6D", "KD", "3C", "6C", "8C", "9C"];


    //     $card = '9H';
    //     $handDeck = $b2;
    //     $playBy = $user4;
    //     $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
    //     $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
    //     $handDeck = array_diff($handDeck, [$card]);
    //     $stake = array_merge($stake, [$card]);
    //     $game = $room->getLatestGame();
    //     $this->assertEquals(array_values($game->b2), array_values($handDeck), 'Mismatch of hand deck');
    //     $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
    //     dump("{$card} - Done");
    //     $b2 = $handDeck;

    //     $card = '2H';
    //     $handDeck = $a1;
    //     $playBy = $user1;
    //     $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
    //     $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
    //     $handDeck = array_diff($handDeck, [$card]);
    //     $stake = array_merge($stake, [$card]);
    //     $game = $room->getLatestGame();
    //     $this->assertEquals(array_values($game->a1), array_values($handDeck), 'Mismatch of hand deck');
    //     $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
    //     dump("{$card} - Done");
    //     $a1 = $handDeck;

    //     $card = '5H';
    //     $handDeck = $b1;
    //     $playBy = $user2;
    //     $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
    //     $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
    //     $handDeck = array_diff($handDeck, [$card]);
    //     $stake = array_merge($stake, [$card]);
    //     $game = $room->getLatestGame();
    //     $this->assertEquals(array_values($game->b1), array_values($handDeck), 'Mismatch of hand deck');
    //     $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
    //     dump("{$card} - Done");
    //     $b1 = $handDeck;

    //     $card = '3H';
    //     $handDeck = $a2;
    //     $playBy = $user3;
    //     $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
    //     $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
    //     $handDeck = array_diff($handDeck, [$card]);
    //     $stake = [];
    //     $game = $room->getLatestGame();
    //     $this->assertEquals(array_values($game->a2), array_values($handDeck), 'Mismatch of hand deck');
    //     $this->assertEquals('S', $game->dehla_score["a1"], 'Mismatch of score');
    //     $this->assertEquals(3, $game->score["b2"], 'Mismatch of score');
    //     $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
    //     $this->assertEquals('b2', $game->next_chance, 'Mismatch of next chance');
    //     dump("{$card} - Done");
    //     $a2 = $handDeck;

    //     // $a1 = ["4H", "JH", "QH", "7D", "TD", "4C", "TC"];
    //     // $a2 = ["6H", "2D", "9D", "JD", "2C", "7C", "KC", "AC"];
    //     // $b1 = ["KS", "3D", "4D", "8D", "QD", "AD", "5C", "QC"];
    //     // $b2 = ["TH", "5D", "6D", "KD", "3C", "6C", "8C", "9C"];


    //     $card = 'TH';
    //     $handDeck = $b2;
    //     $playBy = $user4;
    //     $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
    //     $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
    //     $handDeck = array_diff($handDeck, [$card]);
    //     $stake = array_merge($stake, [$card]);
    //     $game = $room->getLatestGame();
    //     $this->assertEquals(array_values($game->b2), array_values($handDeck), 'Mismatch of hand deck');
    //     $this->assertEquals('S', $game->dehla_score["a1"], 'Mismatch of score');
    //     $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
    //     dump("{$card} - Done");
    //     $b2 = $handDeck;

    //     $res5 = $this->apiAs($user1, 'post', '/api/room/' . $roomCode . '/open-trump');
    //     $this->assertEquals(400, $res5->getStatusCode(), 'Mismatch of status code');

    //     $card = '4H';
    //     $handDeck = $a1;
    //     $playBy = $user1;
    //     $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
    //     $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
    //     $handDeck = array_diff($handDeck, [$card]);
    //     $stake = array_merge($stake, [$card]);
    //     $game = $room->getLatestGame();
    //     $this->assertEquals(array_values($game->a1), array_values($handDeck), 'Mismatch of hand deck');
    //     $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
    //     dump("{$card} - Done");
    //     $a1 = $handDeck;

    //     $res5 = $this->apiAs($user2, 'post', '/api/room/' . $roomCode . '/open-trump');
    //     $this->assertEquals(200, $res5->getStatusCode(), 'Mismatch of status code');
    //     $game = $room->getLatestGame();
    //     $this->assertEquals($game->trump_decided_by, 'b1', 'Mismatch of trump by');
    //     array_push($a1, 'JC');
    //     $this->assertEquals(array_values($game->a1), array_values($a1), 'Mismatch of hand deck');

    //     $card = '5C';
    //     $handDeck = $b1;
    //     $playBy = $user2;
    //     $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
    //     $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
    //     $handDeck = array_diff($handDeck, [$card]);
    //     $stake = array_merge($stake, [$card]);
    //     $game = $room->getLatestGame();
    //     $this->assertEquals(array_values($game->b1), array_values($handDeck), 'Mismatch of hand deck');
    //     $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
    //     dump("{$card} - Done");
    //     $b1 = $handDeck;

    //     $card = '6H';
    //     $handDeck = $a2;
    //     $playBy = $user3;
    //     $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
    //     $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
    //     $handDeck = array_diff($handDeck, [$card]);
    //     $stake = [];
    //     $game = $room->getLatestGame();
    //     $this->assertEquals(array_values($game->a2), array_values($handDeck), 'Mismatch of hand deck');
    //     $this->assertEquals('H', $game->dehla_score["b1"], 'Mismatch of score');
    //     $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
    //     $this->assertEquals('b1', $game->next_chance, 'Mismatch of next chance');
    //     dump("{$card} - Done");
    //     $a2 = $handDeck;
    // }

    /**
     *
     */
    // public function testShouldCreateCorrectGameRecordsIfTrumpIsOpenedWithDifferentBaseDeck()
    // {
    //     $user1 = factory(User::class)->create([
    //         'email' => 'dp@dp.com'
    //     ]);
    //     $user2 = factory(User::class)->create();
    //     $user3 = factory(User::class)->create();
    //     $user4 = factory(User::class)->create();

    //     $response = $this->apiAs($user1, 'post', '/api/room');
    //     $actualData = json_decode($response->getContent(),true)['data'];

    //     $roomCode = $actualData['code'];
    //     dump($roomCode);
    //     $room = Room::whereCode($roomCode)->first();
    //     $room->code = '111111';
    //     $room->save();
    //     $roomCode = '111111';

        
    //     $res1 = $this->apiAs($user1, 'post', '/api/room/' . $roomCode . '/join');
    //     $res1 = json_decode($res1->getContent(), true);

    //     $res2 = $this->apiAs($user2, 'post', '/api/room/' . $roomCode . '/join');
    //     $res2 = json_decode($res2->getContent(), true);

    //     $res3 = $this->apiAs($user3, 'post', '/api/room/' . $roomCode . '/join');
    //     $res3 = json_decode($res3->getContent(), true);

    //     $res4 = $this->apiAs($user4, 'post', '/api/room/' . $roomCode . '/join');
    //     $res4 = json_decode($res4->getContent(), true);

    //     $res1 = $this->apiAs($user1, 'post', '/api/room/' . $roomCode . '/start');
    //     $res1 = json_decode($res1->getContent(), true);

    //     $res1 = $this->apiAs($user1, 'get', '/api/room/' . $roomCode . '/user/initial-cards');
    //     $res1 = json_decode($res1->getContent(), true);

    //     $res2 = $this->apiAs($user2, 'get', '/api/room/' . $roomCode . '/user/initial-cards');
    //     $res2 = json_decode($res2->getContent(), true);

    //     $res3 = $this->apiAs($user3, 'get', '/api/room/' . $roomCode . '/user/initial-cards');
    //     $res3 = json_decode($res3->getContent(), true);

    //     $res4 = $this->apiAs($user4, 'get', '/api/room/' . $roomCode . '/user/initial-cards');
    //     $res4 = json_decode($res4->getContent(), true);

    //     $game = $room->getLatestGame();

    //     $this->assertEquals(12, count($game->a1), 'A1 should have 12 cards');
    //     $this->assertEquals(13, count($game->a2), 'A2 should have 13 cards');
    //     $this->assertEquals(13, count($game->b1), 'B1 should have 13 cards');
    //     $this->assertEquals(13, count($game->b2), 'B2 should have 13 cards');

    //     $a1 = ["7S", "9S", "AS", "2H",  "7H",  "7D", "TD", "4C", "2C", "7C", "TC", "KC"];
    //     $a2 = ["5S", "TS", "QS", "3H", "4H", "6H", "8H", "JH", "QH", "2D", "9D", "JD", "AC"];
    //     $b1 = ["3S", "4S", "8S", "KS", "5H", "KH", "3D", "4D", "8D", "QD", "AD", "5C", "QC"];
    //     $b2 = ["2S", "6S", "JS", "9H", "TH", "AH", "5D", "6D", "KD", "3C", "6C", "8C", "9C"];

    //     $game->a1 = $a1;
    //     $game->a2 = $a2;
    //     $game->b1 = $b1;
    //     $game->b2 = $b2;
    //     $game->trump = 'JC';

    //     $game->save();

    //     $card = 'AS';
    //     $handDeck = $a1;
    //     $playBy = $user1;
    //     $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
    //     $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
    //     $handDeck = array_diff($handDeck, [$card]);
    //     $stake = [$card];
    //     $game = $room->getLatestGame();
    //     $this->assertEquals(array_values($game->a1), array_values($handDeck), 'Mismatch of hand deck');
    //     $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
    //     dump("{$card} - Done");
    //     $a1 = $handDeck;
        

    //     $card = '3S';
    //     $handDeck = $b1;
    //     $playBy = $user2;
    //     $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
    //     $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
    //     $handDeck = array_diff($handDeck, [$card]);
    //     $stake = array_merge($stake, [$card]);
    //     $game = $room->getLatestGame();
    //     $this->assertEquals(array_values($game->b1), array_values($handDeck), 'Mismatch of hand deck');
    //     $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
    //     dump("{$card} - Done");
    //     $b1 = $handDeck;


        
    //     $card = 'TS';
    //     $handDeck = $a2;
    //     $playBy = $user3;
    //     $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
    //     $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
    //     $handDeck = array_diff($handDeck, [$card]);
    //     $stake = array_merge($stake, [$card]);
    //     $game = $room->getLatestGame();
    //     $this->assertEquals(array_values($game->a2), array_values($handDeck), 'Mismatch of hand deck');
    //     $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
    //     dump("{$card} - Done");
    //     $a2 = $handDeck;


    //     $card = '2S';
    //     $handDeck = $b2;
    //     $playBy = $user4;
    //     $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
    //     $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
    //     $handDeck = array_diff($handDeck, [$card]);
    //     $stake = [];
    //     $game = $room->getLatestGame();
    //     $this->assertEquals(array_values($game->b2), array_values($handDeck), 'Mismatch of hand deck');
    //     $this->assertEquals('S', $game->dehla_score["a1"], 'Mismatch of score');
    //     $this->assertEquals('a1', $game->next_chance, 'Mismatch of score');
    //     $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
    //     dump("{$card} - Done");
    //     $b2 = $handDeck;


    //     $card = '9S';
    //     $handDeck = $a1;
    //     $playBy = $user1;
    //     $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
    //     $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
    //     $handDeck = array_diff($handDeck, [$card]);
    //     $stake = array_merge($stake, [$card]);
    //     $game = $room->getLatestGame();
    //     $this->assertEquals(array_values($game->a1), array_values($handDeck), 'Mismatch of hand deck');
    //     $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
    //     dump("{$card} - Done");
    //     $a1 = $handDeck;

    //     $card = '4S';
    //     $handDeck = $b1;
    //     $playBy = $user2;
    //     $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
    //     $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
    //     $handDeck = array_diff($handDeck, [$card]);
    //     $stake = array_merge($stake, [$card]);
    //     $game = $room->getLatestGame();
    //     $this->assertEquals(array_values($game->b1), array_values($handDeck), 'Mismatch of hand deck');
    //     $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
    //     dump("{$card} - Done");
    //     $b1 = $handDeck;


    //     $card = 'QS';
    //     $handDeck = $a2;
    //     $playBy = $user3;
    //     $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
    //     $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
    //     $handDeck = array_diff($handDeck, [$card]);
    //     $stake = array_merge($stake, [$card]);
    //     $game = $room->getLatestGame();
    //     $this->assertEquals(array_values($game->a2), array_values($handDeck), 'Mismatch of hand deck');
    //     $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
    //     dump("{$card} - Done");
    //     $a2 = $handDeck;

    //     $card = '6S';
    //     $handDeck = $b2;
    //     $playBy = $user4;
    //     $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
    //     $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
    //     $handDeck = array_diff($handDeck, [$card]);
    //     $stake = [];
    //     $game = $room->getLatestGame();
    //     $this->assertEquals(array_values($game->b2), array_values($handDeck), 'Mismatch of hand deck');
    //     $this->assertEquals('S', $game->dehla_score["a1"], 'Mismatch of score');
    //     $this->assertEquals(1, $game->score["a2"], 'Mismatch of score');
    //     $this->assertEquals('a2', $game->next_chance, 'Mismatch of next chance');
    //     $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
    //     dump("{$card} - Done");
    //     $b2 = $handDeck;

    //     // $a1 = ["7S", "2H", "4H", "7H", "JH", "QH", "7D", "TD", "4C", "TC"];
    //     // $a2 = ["5S", "3H", "6H", "8H", "2D", "9D", "JD", "2C", "7C", "KC", "AC"];
    //     // $b1 = ["8S", "KS", "5H", "KH", "3D", "4D", "8D", "QD", "AD", "5C", "QC"];
    //     // $b2 = ["JS", "9H", "TH", "AH", "5D", "6D", "KD", "3C", "6C", "8C", "9C"];


    //     $card = '5S';
    //     $handDeck = $a2;
    //     $playBy = $user3;
    //     $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
    //     $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
    //     $handDeck = array_diff($handDeck, [$card]);
    //     $stake = array_merge($stake, [$card]);
    //     $game = $room->getLatestGame();
    //     $this->assertEquals(array_values($game->a2), array_values($handDeck), 'Mismatch of hand deck');
    //     $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
    //     dump("{$card} - Done");
    //     $a2 = $handDeck;

    //     $card = 'JS';
    //     $handDeck = $b2;
    //     $playBy = $user4;
    //     $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
    //     $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
    //     $handDeck = array_diff($handDeck, [$card]);
    //     $stake = array_merge($stake, [$card]);
    //     $game = $room->getLatestGame();
    //     $this->assertEquals(array_values($game->b2), array_values($handDeck), 'Mismatch of hand deck');
    //     $this->assertEquals('S', $game->dehla_score["a1"], 'Mismatch of score');
    //     $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
    //     dump("{$card} - Done");
    //     $b2 = $handDeck;

    //     $card = '7S';
    //     $handDeck = $a1;
    //     $playBy = $user1;
    //     $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
    //     $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
    //     $handDeck = array_diff($handDeck, [$card]);
    //     $stake = array_merge($stake, [$card]);
    //     $game = $room->getLatestGame();
    //     $this->assertEquals(array_values($game->a1), array_values($handDeck), 'Mismatch of hand deck');
    //     $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
    //     dump("{$card} - Done");
    //     $a1 = $handDeck;

    //     $card = '8S';
    //     $handDeck = $b1;
    //     $playBy = $user2;
    //     $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
    //     $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
    //     $handDeck = array_diff($handDeck, [$card]);
    //     $stake = [];
    //     $game = $room->getLatestGame();
    //     $this->assertEquals(array_values($game->b1), array_values($handDeck), 'Mismatch of hand deck');
    //     $this->assertEquals('b2', $game->next_chance, 'Mismatch of next chance');
    //     $this->assertEquals(1, $game->score["b2"], 'Mismatch of score');
    //     $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
    //     dump("{$card} - Done");
    //     $b1 = $handDeck;


    //     // $a1 = ["2H", "4H", "7H", "JH", "QH", "7D", "TD", "4C", "TC"];
    //     // $a2 = ["3H", "6H", "8H", "2D", "9D", "JD", "2C", "7C", "KC", "AC"];
    //     // $b1 = ["KS", "5H", "KH", "3D", "4D", "8D", "QD", "AD", "5C", "QC"];
    //     // $b2 = ["9H", "TH", "AH", "5D", "6D", "KD", "3C", "6C", "8C", "9C"];


    //     $card = 'AH';
    //     $handDeck = $b2;
    //     $playBy = $user4;
    //     $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
    //     $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
    //     $handDeck = array_diff($handDeck, [$card]);
    //     $stake = array_merge($stake, [$card]);
    //     $game = $room->getLatestGame();
    //     $this->assertEquals(array_values($game->b2), array_values($handDeck), 'Mismatch of hand deck');
    //     $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
    //     dump("{$card} - Done");
    //     $b2 = $handDeck;

    //     $card = '7H';
    //     $handDeck = $a1;
    //     $playBy = $user1;
    //     $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
    //     $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
    //     $handDeck = array_diff($handDeck, [$card]);
    //     $stake = array_merge($stake, [$card]);
    //     $game = $room->getLatestGame();
    //     $this->assertEquals(array_values($game->a1), array_values($handDeck), 'Mismatch of hand deck');
    //     $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
    //     dump("{$card} - Done");
    //     $a1 = $handDeck;

    //     $card = 'KH';
    //     $handDeck = $b1;
    //     $playBy = $user2;
    //     $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
    //     $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
    //     $handDeck = array_diff($handDeck, [$card]);
    //     $stake = array_merge($stake, [$card]);
    //     $game = $room->getLatestGame();
    //     $this->assertEquals(array_values($game->b1), array_values($handDeck), 'Mismatch of hand deck');
    //     $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
    //     dump("{$card} - Done");
    //     $b1 = $handDeck;

    //     $card = '8H';
    //     $handDeck = $a2;
    //     $playBy = $user3;
    //     $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
    //     $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
    //     $handDeck = array_diff($handDeck, [$card]);
    //     $stake = [];
    //     $game = $room->getLatestGame();
    //     $this->assertEquals(array_values($game->a2), array_values($handDeck), 'Mismatch of hand deck');
    //     $this->assertEquals(2, $game->score["b2"], 'Mismatch of score');
    //     $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
    //     $this->assertEquals('b2', $game->next_chance, 'Mismatch of next chance');
    //     dump("{$card} - Done");
    //     $a2 = $handDeck;

    //     // $a1 = ["2H", "4H", "JH", "QH", "7D", "TD", "4C", "TC"];
    //     // $a2 = ["3H", "6H", "2D", "9D", "JD", "2C", "7C", "KC", "AC"];
    //     // $b1 = ["KS", "5H", "3D", "4D", "8D", "QD", "AD", "5C", "QC"];
    //     // $b2 = ["9H", "TH", "5D", "6D", "KD", "3C", "6C", "8C", "9C"];

    //     $card = '9H';
    //     $handDeck = $b2;
    //     $playBy = $user4;
    //     $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
    //     $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
    //     $handDeck = array_diff($handDeck, [$card]);
    //     $stake = array_merge($stake, [$card]);
    //     $game = $room->getLatestGame();
    //     $this->assertEquals(array_values($game->b2), array_values($handDeck), 'Mismatch of hand deck');
    //     $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
    //     dump("{$card} - Done");
    //     $b2 = $handDeck;

    //     $card = '2H';
    //     $handDeck = $a1;
    //     $playBy = $user1;
    //     $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
    //     $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
    //     $handDeck = array_diff($handDeck, [$card]);
    //     $stake = array_merge($stake, [$card]);
    //     $game = $room->getLatestGame();
    //     $this->assertEquals(array_values($game->a1), array_values($handDeck), 'Mismatch of hand deck');
    //     $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
    //     dump("{$card} - Done");
    //     $a1 = $handDeck;

    //     $card = '5H';
    //     $handDeck = $b1;
    //     $playBy = $user2;
    //     $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
    //     $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
    //     $handDeck = array_diff($handDeck, [$card]);
    //     $stake = array_merge($stake, [$card]);
    //     $game = $room->getLatestGame();
    //     $this->assertEquals(array_values($game->b1), array_values($handDeck), 'Mismatch of hand deck');
    //     $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
    //     dump("{$card} - Done");
    //     $b1 = $handDeck;

    //     $card = '3H';
    //     $handDeck = $a2;
    //     $playBy = $user3;
    //     $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
    //     $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
    //     $handDeck = array_diff($handDeck, [$card]);
    //     $stake = [];
    //     $game = $room->getLatestGame();
    //     $this->assertEquals(array_values($game->a2), array_values($handDeck), 'Mismatch of hand deck');
    //     $this->assertEquals('S', $game->dehla_score["a1"], 'Mismatch of score');
    //     $this->assertEquals(3, $game->score["b2"], 'Mismatch of score');
    //     $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
    //     $this->assertEquals('b2', $game->next_chance, 'Mismatch of next chance');
    //     dump("{$card} - Done");
    //     $a2 = $handDeck;

    //     // $a1 = ["7D", "TD", "4C", "2C", "7C", "KC", "TC"];
    //     // $a2 = ["4H", "6H", "JH", "QH", "2D", "9D", "JD", "AC"];
    //     // $b1 = ["KS", "3D", "4D", "8D", "QD", "AD", "5C", "QC"];
    //     // $b2 = ["TH", "5D", "6D", "KD", "3C", "6C", "8C", "9C"];


    //     $card = 'TH';
    //     $handDeck = $b2;
    //     $playBy = $user4;
    //     $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
    //     $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
    //     $handDeck = array_diff($handDeck, [$card]);
    //     $stake = array_merge($stake, [$card]);
    //     $game = $room->getLatestGame();
    //     $this->assertEquals(array_values($game->b2), array_values($handDeck), 'Mismatch of hand deck');
    //     $this->assertEquals('S', $game->dehla_score["a1"], 'Mismatch of score');
    //     $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
    //     dump("{$card} - Done");
    //     $b2 = $handDeck;

    //     $res5 = $this->apiAs($user1, 'post', '/api/room/' . $roomCode . '/open-trump');
    //     $this->assertEquals(400, $res5->getStatusCode(), 'Mismatch of status code');

    //     $card = 'TC';
    //     $handDeck = $a1;
    //     $playBy = $user1;
    //     $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
    //     $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
    //     $handDeck = array_diff($handDeck, [$card]);
    //     $stake = array_merge($stake, [$card]);
    //     $game = $room->getLatestGame();
    //     $this->assertEquals(array_values($game->a1), array_values($handDeck), 'Mismatch of hand deck');
    //     $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
    //     dump("{$card} - Done");
    //     $a1 = $handDeck;

    //     $res5 = $this->apiAs($user2, 'post', '/api/room/' . $roomCode . '/open-trump');
    //     $this->assertEquals(200, $res5->getStatusCode(), 'Mismatch of status code');
    //     $game = $room->getLatestGame();
    //     $this->assertEquals($game->trump_decided_by, 'b1', 'Mismatch of trump by');
    //     array_push($a1, 'JC');
    //     $this->assertEquals(array_values($game->a1), array_values($a1), 'Mismatch of hand deck');

    //     $card = '5C';
    //     $handDeck = $b1;
    //     $playBy = $user2;
    //     $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
    //     $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
    //     $handDeck = array_diff($handDeck, [$card]);
    //     $stake = array_merge($stake, [$card]);
    //     $game = $room->getLatestGame();
    //     $this->assertEquals(array_values($game->b1), array_values($handDeck), 'Mismatch of hand deck');
    //     $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
    //     dump("{$card} - Done");
    //     $b1 = $handDeck;

    //     $card = '6H';
    //     $handDeck = $a2;
    //     $playBy = $user3;
    //     $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
    //     $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
    //     $handDeck = array_diff($handDeck, [$card]);
    //     $stake = [];
    //     $game = $room->getLatestGame();
    //     $this->assertEquals(array_values($game->a2), array_values($handDeck), 'Mismatch of hand deck');
    //     $this->assertEquals('HC', $game->dehla_score["b1"], 'Mismatch of score');
    //     $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
    //     $this->assertEquals('b1', $game->next_chance, 'Mismatch of next chance');
    //     dump("{$card} - Done");
    //     $a2 = $handDeck;

    //     // $a1 = ["7D", "TD", "4C", "2C", "7C", "KC", "TC"];
    //     // $a2 = ["4H", "6H", "JH", "QH", "2D", "9D", "JD", "AC"];
    //     // $b1 = ["KS", "3D", "4D", "8D", "QD", "AD", "5C", "QC"];
    //     // $b2 = ["TH", "5D", "6D", "KD", "3C", "6C", "8C", "9C"];


    //     $card = '3D';
    //     $handDeck = $b1;
    //     $playBy = $user2;
    //     $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
    //     $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
    //     $handDeck = array_diff($handDeck, [$card]);
    //     $stake = array_merge($stake, [$card]);
    //     $game = $room->getLatestGame();
    //     $this->assertEquals(array_values($game->b1), array_values($handDeck), 'Mismatch of hand deck');
    //     $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
    //     dump("{$card} - Done");
    //     $b1 = $handDeck;

    //     $card = '2D';
    //     $handDeck = $a2;
    //     $playBy = $user3;
    //     $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
    //     $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
    //     $handDeck = array_diff($handDeck, [$card]);
    //     $stake = array_merge($stake, [$card]);
    //     $game = $room->getLatestGame();
    //     $this->assertEquals(array_values($game->a2), array_values($handDeck), 'Mismatch of hand deck');
    //     $this->assertEquals('HC', $game->dehla_score["b1"], 'Mismatch of score');
    //     $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
    //     $this->assertEquals('b2', $game->next_chance, 'Mismatch of next chance');
    //     dump("{$card} - Done");
    //     $a2 = $handDeck;

    //     $card = '5D';
    //     $handDeck = $b2;
    //     $playBy = $user4;
    //     $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
    //     $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
    //     $handDeck = array_diff($handDeck, [$card]);
    //     $stake = array_merge($stake, [$card]);
    //     $game = $room->getLatestGame();
    //     $this->assertEquals(array_values($game->b2), array_values($handDeck), 'Mismatch of hand deck');
    //     $this->assertEquals('S', $game->dehla_score["a1"], 'Mismatch of score');
    //     $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
    //     dump("{$card} - Done");
    //     $b2 = $handDeck;

        


    //     $games = $room->games;

    //     // foreach ($games as $roomGame) {
    //     //     dump($roomGame->getAttributes());
    //     //     dump($roomGame->next_chance);
    //     // }

    //     // dump($game);
    // }

        /**
     *
     */
    public function testShouldCreateCorrectGameRecordsIfTrumpIsOpenedWithDifferentBaseDeck()
    {
        $this->withoutEvents();
        $user1 = factory(User::class)->create();
        $user2 = factory(User::class)->create();
        $user3 = factory(User::class)->create([
            'email' => 'dp@dp.com'
        ]);
        $user4 = factory(User::class)->create([
            'email' => 'dp1@dp.com'
        ]);

        $response = $this->apiAs($user1, 'post', '/api/room');
        dump($response);
        $actualData = json_decode($response->getContent(),true)['data'];

        $roomCode = $actualData['code'];
        // dump($roomCode);
        $room = Room::whereCode($roomCode)->first();
        $room->code = '111111';
        $room->save();
        $roomCode = '111111';

        
        $res1 = $this->apiAs($user1, 'post', '/api/room/' . $roomCode . '/join');
        $res1 = json_decode($res1->getContent(), true);

        $res2 = $this->apiAs($user2, 'post', '/api/room/' . $roomCode . '/join');
        $res2 = json_decode($res2->getContent(), true);

        $res3 = $this->apiAs($user3, 'post', '/api/room/' . $roomCode . '/join');
        $res3 = json_decode($res3->getContent(), true);

        $res4 = $this->apiAs($user4, 'post', '/api/room/' . $roomCode . '/join');
        $res4 = json_decode($res4->getContent(), true);

        $res1 = $this->apiAs($user1, 'post', '/api/room/' . $roomCode . '/start');
        $res1 = json_decode($res1->getContent(), true);

        $res1 = $this->apiAs($user1, 'get', '/api/room/' . $roomCode . '/user/initial-cards');
        $res1 = json_decode($res1->getContent(), true);

        $res2 = $this->apiAs($user2, 'get', '/api/room/' . $roomCode . '/user/initial-cards');
        $res2 = json_decode($res2->getContent(), true);

        $res3 = $this->apiAs($user3, 'get', '/api/room/' . $roomCode . '/user/initial-cards');
        $res3 = json_decode($res3->getContent(), true);

        $res4 = $this->apiAs($user4, 'get', '/api/room/' . $roomCode . '/user/initial-cards');
        $res4 = json_decode($res4->getContent(), true);

        $game = $room->getLatestGame();

        $this->assertEquals(12, count($game->a1), 'A1 should have 12 cards');
        $this->assertEquals(13, count($game->a2), 'A2 should have 13 cards');
        $this->assertEquals(13, count($game->b1), 'B1 should have 13 cards');
        $this->assertEquals(13, count($game->b2), 'B2 should have 13 cards');

        $a1 = ["7S", "9S", "AS", "2H",  "7H",  "7D", "TD", "4C", "2C", "7C", "TC", "KC"];
        $a2 = ["5S", "TS", "QS", "3H", "4H", "6H", "8H", "JH", "QH", "2D", "9D", "JD", "AC"];
        $b1 = ["3S", "4S", "8S", "KS", "5H", "KH", "3D", "4D", "8D", "QD", "AD", "5C", "QC"];
        $b2 = ["2S", "6S", "JS", "9H", "TH", "AH", "5D", "6D", "KD", "3C", "6C", "8C", "9C"];

        $game->a1 = $a1;
        $game->a2 = $a2;
        $game->b1 = $b1;
        $game->b2 = $b2;
        $game->trump = 'JC';

        $game->save();

        $card = 'AS';
        $handDeck = $a1;
        $playBy = $user1;
        $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
        $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
        $handDeck = array_diff($handDeck, [$card]);
        $stake = [$card];
        $game = $room->getLatestGame();
        $this->assertEquals(array_values($game->a1), array_values($handDeck), 'Mismatch of hand deck');
        $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
        // dump("{$card} - Done");
        $a1 = $handDeck;
        

        $card = '3S';
        $handDeck = $b1;
        $playBy = $user2;
        $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
        $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
        $handDeck = array_diff($handDeck, [$card]);
        $stake = array_merge($stake, [$card]);
        $game = $room->getLatestGame();
        $this->assertEquals(array_values($game->b1), array_values($handDeck), 'Mismatch of hand deck');
        $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
        // dump("{$card} - Done");
        $b1 = $handDeck;


        
        // $card = 'TS';
        // $handDeck = $a2;
        // $playBy = $user3;
        // $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
        // $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
        // $handDeck = array_diff($handDeck, [$card]);
        // $stake = array_merge($stake, [$card]);
        // $game = $room->getLatestGame();
        // $this->assertEquals(array_values($game->a2), array_values($handDeck), 'Mismatch of hand deck');
        // $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
        // // dump("{$card} - Done");
        // $a2 = $handDeck;


        // $card = '2S';
        // $handDeck = $b2;
        // $playBy = $user4;
        // $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
        // $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
        // $handDeck = array_diff($handDeck, [$card]);
        // $stake = [];
        // $game = $room->getLatestGame();
        // $this->assertEquals(array_values($game->b2), array_values($handDeck), 'Mismatch of hand deck');
        // $this->assertEquals('S', $game->dehla_score["a1"], 'Mismatch of score');
        // $this->assertEquals('a1', $game->next_chance, 'Mismatch of score');
        // $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
        // // dump("{$card} - Done");
        // $b2 = $handDeck;


        // $card = '9S';
        // $handDeck = $a1;
        // $playBy = $user1;
        // $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
        // $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
        // $handDeck = array_diff($handDeck, [$card]);
        // $stake = array_merge($stake, [$card]);
        // $game = $room->getLatestGame();
        // $this->assertEquals(array_values($game->a1), array_values($handDeck), 'Mismatch of hand deck');
        // $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
        // // dump("{$card} - Done");
        // $a1 = $handDeck;

        // $card = '4S';
        // $handDeck = $b1;
        // $playBy = $user2;
        // $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
        // $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
        // $handDeck = array_diff($handDeck, [$card]);
        // $stake = array_merge($stake, [$card]);
        // $game = $room->getLatestGame();
        // $this->assertEquals(array_values($game->b1), array_values($handDeck), 'Mismatch of hand deck');
        // $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
        // // dump("{$card} - Done");
        // $b1 = $handDeck;


        // $card = 'QS';
        // $handDeck = $a2;
        // $playBy = $user3;
        // $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
        // $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
        // $handDeck = array_diff($handDeck, [$card]);
        // $stake = array_merge($stake, [$card]);
        // $game = $room->getLatestGame();
        // $this->assertEquals(array_values($game->a2), array_values($handDeck), 'Mismatch of hand deck');
        // $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
        // // dump("{$card} - Done");
        // $a2 = $handDeck;

        // $card = '6S';
        // $handDeck = $b2;
        // $playBy = $user4;
        // $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
        // $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
        // $handDeck = array_diff($handDeck, [$card]);
        // $stake = [];
        // $game = $room->getLatestGame();
        // $this->assertEquals(array_values($game->b2), array_values($handDeck), 'Mismatch of hand deck');
        // $this->assertEquals('S', $game->dehla_score["a1"], 'Mismatch of score');
        // $this->assertEquals(1, $game->score["a2"], 'Mismatch of score');
        // $this->assertEquals('a2', $game->next_chance, 'Mismatch of next chance');
        // $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
        // // dump("{$card} - Done");
        // $b2 = $handDeck;

        // // $a1 = ["7S", "2H", "4H", "7H", "JH", "QH", "7D", "TD", "4C", "TC"];
        // // $a2 = ["5S", "3H", "6H", "8H", "2D", "9D", "JD", "2C", "7C", "KC", "AC"];
        // // $b1 = ["8S", "KS", "5H", "KH", "3D", "4D", "8D", "QD", "AD", "5C", "QC"];
        // // $b2 = ["JS", "9H", "TH", "AH", "5D", "6D", "KD", "3C", "6C", "8C", "9C"];


        // $card = '5S';
        // $handDeck = $a2;
        // $playBy = $user3;
        // $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
        // $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
        // $handDeck = array_diff($handDeck, [$card]);
        // $stake = array_merge($stake, [$card]);
        // $game = $room->getLatestGame();
        // $this->assertEquals(array_values($game->a2), array_values($handDeck), 'Mismatch of hand deck');
        // $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
        // // dump("{$card} - Done");
        // $a2 = $handDeck;

        // $card = 'JS';
        // $handDeck = $b2;
        // $playBy = $user4;
        // $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
        // $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
        // $handDeck = array_diff($handDeck, [$card]);
        // $stake = array_merge($stake, [$card]);
        // $game = $room->getLatestGame();
        // $this->assertEquals(array_values($game->b2), array_values($handDeck), 'Mismatch of hand deck');
        // $this->assertEquals('S', $game->dehla_score["a1"], 'Mismatch of score');
        // $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
        // // dump("{$card} - Done");
        // $b2 = $handDeck;

        // $card = '7S';
        // $handDeck = $a1;
        // $playBy = $user1;
        // $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
        // $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
        // $handDeck = array_diff($handDeck, [$card]);
        // $stake = array_merge($stake, [$card]);
        // $game = $room->getLatestGame();
        // $this->assertEquals(array_values($game->a1), array_values($handDeck), 'Mismatch of hand deck');
        // $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
        // // dump("{$card} - Done");
        // $a1 = $handDeck;

        // $card = '8S';
        // $handDeck = $b1;
        // $playBy = $user2;
        // $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
        // // dump($res5);
        // $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
        // $handDeck = array_diff($handDeck, [$card]);
        // $stake = [];
        // $game = $room->getLatestGame();
        // $this->assertEquals(array_values($game->b1), array_values($handDeck), 'Mismatch of hand deck');
        // $this->assertEquals('b2', $game->next_chance, 'Mismatch of next chance');
        // $this->assertEquals(1, $game->score["b2"], 'Mismatch of score');
        // $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
        // // dump("{$card} - Done");
        // $b1 = $handDeck;


        // // $a1 = ["2H", "4H", "7H", "JH", "QH", "7D", "TD", "4C", "TC"];
        // // $a2 = ["3H", "6H", "8H", "2D", "9D", "JD", "2C", "7C", "KC", "AC"];
        // // $b1 = ["KS", "5H", "KH", "3D", "4D", "8D", "QD", "AD", "5C", "QC"];
        // // $b2 = ["9H", "TH", "AH", "5D", "6D", "KD", "3C", "6C", "8C", "9C"];


        // $card = 'AH';
        // $handDeck = $b2;
        // $playBy = $user4;
        // $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
        // $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
        // $handDeck = array_diff($handDeck, [$card]);
        // $stake = array_merge($stake, [$card]);
        // $game = $room->getLatestGame();
        // $this->assertEquals(array_values($game->b2), array_values($handDeck), 'Mismatch of hand deck');
        // $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
        // // dump("{$card} - Done");
        // $b2 = $handDeck;

        // $card = '7H';
        // $handDeck = $a1;
        // $playBy = $user1;
        // $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
        // $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
        // $handDeck = array_diff($handDeck, [$card]);
        // $stake = array_merge($stake, [$card]);
        // $game = $room->getLatestGame();
        // $this->assertEquals(array_values($game->a1), array_values($handDeck), 'Mismatch of hand deck');
        // $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
        // // dump("{$card} - Done");
        // $a1 = $handDeck;

        // $card = 'KH';
        // $handDeck = $b1;
        // $playBy = $user2;
        // $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
        // $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
        // $handDeck = array_diff($handDeck, [$card]);
        // $stake = array_merge($stake, [$card]);
        // $game = $room->getLatestGame();
        // $this->assertEquals(array_values($game->b1), array_values($handDeck), 'Mismatch of hand deck');
        // $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
        // // dump("{$card} - Done");
        // $b1 = $handDeck;

        // $card = '8H';
        // $handDeck = $a2;
        // $playBy = $user3;
        // $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
        // $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
        // $handDeck = array_diff($handDeck, [$card]);
        // $stake = [];
        // $game = $room->getLatestGame();
        // $this->assertEquals(array_values($game->a2), array_values($handDeck), 'Mismatch of hand deck');
        // $this->assertEquals(2, $game->score["b2"], 'Mismatch of score');
        // $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
        // $this->assertEquals('b2', $game->next_chance, 'Mismatch of next chance');
        // // dump("{$card} - Done");
        // $a2 = $handDeck;

        // // $a1 = ["2H", "4H", "JH", "QH", "7D", "TD", "4C", "TC"];
        // // $a2 = ["3H", "6H", "2D", "9D", "JD", "2C", "7C", "KC", "AC"];
        // // $b1 = ["KS", "5H", "3D", "4D", "8D", "QD", "AD", "5C", "QC"];
        // // $b2 = ["9H", "TH", "5D", "6D", "KD", "3C", "6C", "8C", "9C"];

        // $card = '9H';
        // $handDeck = $b2;
        // $playBy = $user4;
        // $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
        // $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
        // $handDeck = array_diff($handDeck, [$card]);
        // $stake = array_merge($stake, [$card]);
        // $game = $room->getLatestGame();
        // $this->assertEquals(array_values($game->b2), array_values($handDeck), 'Mismatch of hand deck');
        // $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
        // // dump("{$card} - Done");
        // $b2 = $handDeck;

        // $card = '2H';
        // $handDeck = $a1;
        // $playBy = $user1;
        // $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
        // $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
        // $handDeck = array_diff($handDeck, [$card]);
        // $stake = array_merge($stake, [$card]);
        // $game = $room->getLatestGame();
        // $this->assertEquals(array_values($game->a1), array_values($handDeck), 'Mismatch of hand deck');
        // $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
        // // dump("{$card} - Done");
        // $a1 = $handDeck;

        // $card = '5H';
        // $handDeck = $b1;
        // $playBy = $user2;
        // $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
        // $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
        // $handDeck = array_diff($handDeck, [$card]);
        // $stake = array_merge($stake, [$card]);
        // $game = $room->getLatestGame();
        // $this->assertEquals(array_values($game->b1), array_values($handDeck), 'Mismatch of hand deck');
        // $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
        // // dump("{$card} - Done");
        // $b1 = $handDeck;

        // $card = '3H';
        // $handDeck = $a2;
        // $playBy = $user3;
        // $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
        // $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
        // $handDeck = array_diff($handDeck, [$card]);
        // $stake = [];
        // $game = $room->getLatestGame();
        // $this->assertEquals(array_values($game->a2), array_values($handDeck), 'Mismatch of hand deck');
        // $this->assertEquals('S', $game->dehla_score["a1"], 'Mismatch of score');
        // $this->assertEquals(3, $game->score["b2"], 'Mismatch of score');
        // $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
        // $this->assertEquals('b2', $game->next_chance, 'Mismatch of next chance');
        // // dump("{$card} - Done");
        // $a2 = $handDeck;

        // // $a1 = ["7D", "TD", "4C", "2C", "7C", "KC", "TC"];
        // // $a2 = ["4H", "6H", "JH", "QH", "2D", "9D", "JD", "AC"];
        // // $b1 = ["KS", "3D", "4D", "8D", "QD", "AD", "5C", "QC"];
        // // $b2 = ["TH", "5D", "6D", "KD", "3C", "6C", "8C", "9C"];


        // $card = 'TH';
        // $handDeck = $b2;
        // $playBy = $user4;
        // $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
        // $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
        // $handDeck = array_diff($handDeck, [$card]);
        // $stake = array_merge($stake, [$card]);
        // $game = $room->getLatestGame();
        // $this->assertEquals(array_values($game->b2), array_values($handDeck), 'Mismatch of hand deck');
        // $this->assertEquals('S', $game->dehla_score["a1"], 'Mismatch of score');
        // $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
        // // dump("{$card} - Done");
        // $b2 = $handDeck;

        // $res5 = $this->apiAs($user1, 'post', '/api/room/' . $roomCode . '/open-trump');
        // $this->assertEquals(400, $res5->getStatusCode(), 'Mismatch of status code');

        // $card = 'TC';
        // $handDeck = $a1;
        // $playBy = $user1;
        // $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
        // $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
        // $handDeck = array_diff($handDeck, [$card]);
        // $stake = array_merge($stake, [$card]);
        // $game = $room->getLatestGame();
        // $this->assertEquals(array_values($game->a1), array_values($handDeck), 'Mismatch of hand deck');
        // $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
        // // dump("{$card} - Done");
        // $a1 = $handDeck;

        // $res5 = $this->apiAs($user2, 'post', '/api/room/' . $roomCode . '/open-trump');
        // $this->assertEquals(200, $res5->getStatusCode(), 'Mismatch of status code');
        // $game = $room->getLatestGame();
        // $this->assertEquals($game->trump_decided_by, 'b1', 'Mismatch of trump by');
        // array_push($a1, 'JC');
        // $this->assertEquals(array_values($game->a1), array_values($a1), 'Mismatch of hand deck');

        // $card = '5C';
        // $handDeck = $b1;
        // $playBy = $user2;
        // $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
        // $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
        // $handDeck = array_diff($handDeck, [$card]);
        // $stake = array_merge($stake, [$card]);
        // $game = $room->getLatestGame();
        // $this->assertEquals(array_values($game->b1), array_values($handDeck), 'Mismatch of hand deck');
        // $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
        // // dump("{$card} - Done");
        // $b1 = $handDeck;

        // $card = '6H';
        // $handDeck = $a2;
        // $playBy = $user3;
        // $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
        // $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
        // $handDeck = array_diff($handDeck, [$card]);
        // $stake = [];
        // $game = $room->getLatestGame();
        // $this->assertEquals(array_values($game->a2), array_values($handDeck), 'Mismatch of hand deck');
        // $this->assertEquals('HC', $game->dehla_score["b1"], 'Mismatch of score');
        // $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
        // $this->assertEquals('b1', $game->next_chance, 'Mismatch of next chance');
        // // dump("{$card} - Done");
        // $a2 = $handDeck;

        // // $a1 = ["7D", "TD", "4C", "2C", "7C", "JC", "KC"];
        // // $a2 = ["4H", "JH", "QH", "2D", "9D", "JD", "AC"];
        // // $b1 = ["KS", "3D", "4D", "8D", "QD", "AD", "QC"];
        // // $b2 = ["5D", "6D", "KD", "3C", "6C", "8C", "9C"];


        // $card = '3D';
        // $handDeck = $b1;
        // $playBy = $user2;
        // $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
        // $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
        // $handDeck = array_diff($handDeck, [$card]);
        // $stake = array_merge($stake, [$card]);
        // $game = $room->getLatestGame();
        // $this->assertEquals(array_values($game->b1), array_values($handDeck), 'Mismatch of hand deck');
        // $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
        // // dump("{$card} - Done");
        // $b1 = $handDeck;

        // $card = '2D';
        // $handDeck = $a2;
        // $playBy = $user3;
        // $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
        // $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
        // $handDeck = array_diff($handDeck, [$card]);
        // $stake = array_merge($stake, [$card]);
        // $game = $room->getLatestGame();
        // $this->assertEquals(array_values($game->a2), array_values($handDeck), 'Mismatch of hand deck');
        // $this->assertEquals('HC', $game->dehla_score["b1"], 'Mismatch of score');
        // $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
        // $this->assertEquals('b2', $game->next_chance, 'Mismatch of next chance');
        // // dump("{$card} - Done");
        // $a2 = $handDeck;

        // $card = '5D';
        // $handDeck = $b2;
        // $playBy = $user4;
        // $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
        // $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
        // $handDeck = array_diff($handDeck, [$card]);
        // $stake = array_merge($stake, [$card]);
        // $game = $room->getLatestGame();
        // $this->assertEquals(array_values($game->b2), array_values($handDeck), 'Mismatch of hand deck');
        // $this->assertEquals('S', $game->dehla_score["a1"], 'Mismatch of score');
        // $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
        // // dump("{$card} - Done");
        // $b2 = $handDeck;

        // $card = '7D';
        // $handDeck = $a1;
        // $playBy = $user1;
        // $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
        // $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
        // $handDeck = array_diff($handDeck, [$card]);
        // $stake = [];
        // $game = $room->getLatestGame();
        // $this->assertEquals(array_values($game->a1), array_values($handDeck), 'Mismatch of hand deck');
        // $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
        // // dump("{$card} - Done");
        // $a1 = $handDeck;

        // // $a1 = ["TD", "4C", "2C", "7C", "JC", "KC"];
        // // $a2 = ["4H", "JH", "QH", "9D", "JD", "AC"];
        // // $b1 = ["KS", "4D", "8D", "QD", "AD", "QC"];
        // // $b2 = ["6D", "KD", "3C", "6C", "8C", "9C"];


        // $card = 'TD';
        // $handDeck = $a1;
        // $playBy = $user1;
        // $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
        // $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
        // $handDeck = array_diff($handDeck, [$card]);
        // $stake = array_merge($stake, [$card]);
        // $game = $room->getLatestGame();
        // $this->assertEquals(array_values($game->a1), array_values($handDeck), 'Mismatch of hand deck');
        // $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
        // // dump("{$card} - Done");
        // $a1 = $handDeck;

        // $card = '4D';
        // $handDeck = $b1;
        // $playBy = $user2;
        // $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
        // $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
        // $handDeck = array_diff($handDeck, [$card]);
        // $stake = array_merge($stake, [$card]);
        // $game = $room->getLatestGame();
        // $this->assertEquals(array_values($game->b1), array_values($handDeck), 'Mismatch of hand deck');
        // $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
        // // dump("{$card} - Done");
        // $b1 = $handDeck;

        // $card = 'JD';
        // $handDeck = $a2;
        // $playBy = $user3;
        // $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
        // $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
        // $handDeck = array_diff($handDeck, [$card]);
        // $stake = array_merge($stake, [$card]);
        // $game = $room->getLatestGame();
        // $this->assertEquals(array_values($game->a2), array_values($handDeck), 'Mismatch of hand deck');
        // $this->assertEquals('HC', $game->dehla_score["b1"], 'Mismatch of score');
        // $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
        // $this->assertEquals('b2', $game->next_chance, 'Mismatch of next chance');
        // // dump("{$card} - Done");
        // $a2 = $handDeck;

        // $card = 'KD';
        // $handDeck = $b2;
        // $playBy = $user4;
        // $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
        // $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
        // $handDeck = array_diff($handDeck, [$card]);
        // $stake = [];
        // $game = $room->getLatestGame();
        // $this->assertEquals(array_values($game->b2), array_values($handDeck), 'Mismatch of hand deck');
        // $this->assertEquals('S', $game->dehla_score["a1"], 'Mismatch of score');
        // $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
        // // dump("{$card} - Done");
        // $b2 = $handDeck;


        // // $a1 = ["4C", "2C", "7C", "JC", "KC"];
        // // $a2 = ["4H", "JH", "QH", "9D", "AC"];
        // // $b1 = ["KS", "8D", "QD", "AD", "QC"];
        // // $b2 = ["6D", "3C", "6C", "8C", "9C"];


        // $card = '6D';
        // $handDeck = $b2;
        // $playBy = $user4;
        // $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
        // $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
        // $handDeck = array_diff($handDeck, [$card]);
        // $stake = array_merge($stake, [$card]);
        // $game = $room->getLatestGame();
        // $this->assertEquals(array_values($game->b2), array_values($handDeck), 'Mismatch of hand deck');
        // $this->assertEquals('S', $game->dehla_score["a1"], 'Mismatch of score');
        // $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
        // // dump("{$card} - Done");
        // $b2 = $handDeck;

        // $card = '4C';
        // $handDeck = $a1;
        // $playBy = $user1;
        // $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
        // $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
        // $handDeck = array_diff($handDeck, [$card]);
        // $stake = array_merge($stake, [$card]);
        // $game = $room->getLatestGame();
        // $this->assertEquals(array_values($game->a1), array_values($handDeck), 'Mismatch of hand deck');
        // $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
        // // dump("{$card} - Done");
        // $a1 = $handDeck;

        // $card = '8D';
        // $handDeck = $b1;
        // $playBy = $user2;
        // $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
        // $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
        // $handDeck = array_diff($handDeck, [$card]);
        // $stake = array_merge($stake, [$card]);
        // $game = $room->getLatestGame();
        // $this->assertEquals(array_values($game->b1), array_values($handDeck), 'Mismatch of hand deck');
        // $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
        // // dump("{$card} - Done");
        // $b1 = $handDeck;

        // $card = '9D';
        // $handDeck = $a2;
        // $playBy = $user3;
        // $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
        // $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
        // $handDeck = array_diff($handDeck, [$card]);
        // $stake = [];
        // $game = $room->getLatestGame();
        // $this->assertEquals(array_values($game->a2), array_values($handDeck), 'Mismatch of hand deck');
        // $this->assertEquals('HC', $game->dehla_score["b1"], 'Mismatch of score');
        // $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
        // $this->assertEquals('a1', $game->next_chance, 'Mismatch of next chance');
        // // dump("{$card} - Done");
        // $a2 = $handDeck;


        // // $a1 = ["2C", "7C", "JC", "KC"];
        // // $a2 = ["4H", "JH", "QH", "AC"];
        // // $b1 = ["KS", "QD", "AD", "QC"];
        // // $b2 = ["3C", "6C", "8C", "9C"];


        // $card = '7C';
        // $handDeck = $a1;
        // $playBy = $user1;
        // $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
        // $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
        // $handDeck = array_diff($handDeck, [$card]);
        // $stake = array_merge($stake, [$card]);
        // $game = $room->getLatestGame();
        // $this->assertEquals(array_values($game->a1), array_values($handDeck), 'Mismatch of hand deck');
        // $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
        // // dump("{$card} - Done");
        // $a1 = $handDeck;

        // $card = 'QC';
        // $handDeck = $b1;
        // $playBy = $user2;
        // $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
        // $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
        // $handDeck = array_diff($handDeck, [$card]);
        // $stake = array_merge($stake, [$card]);
        // $game = $room->getLatestGame();
        // $this->assertEquals(array_values($game->b1), array_values($handDeck), 'Mismatch of hand deck');
        // $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
        // // dump("{$card} - Done");
        // $b1 = $handDeck;

        // $card = 'AC';
        // $handDeck = $a2;
        // $playBy = $user3;
        // $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
        // $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
        // $handDeck = array_diff($handDeck, [$card]);
        // $stake = array_merge($stake, [$card]);
        // $game = $room->getLatestGame();
        // $this->assertEquals(array_values($game->a2), array_values($handDeck), 'Mismatch of hand deck');
        // $this->assertEquals('HC', $game->dehla_score["b1"], 'Mismatch of score');
        // $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
        // // dump("{$card} - Done");
        // $a2 = $handDeck;

        // $card = '3C';
        // $handDeck = $b2;
        // $playBy = $user4;
        // $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
        // $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
        // $handDeck = array_diff($handDeck, [$card]);
        // $stake = [];
        // $game = $room->getLatestGame();
        // $this->assertEquals(array_values($game->b2), array_values($handDeck), 'Mismatch of hand deck');
        // $this->assertEquals('S', $game->dehla_score["a1"], 'Mismatch of score');
        // $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
        // $this->assertEquals('a2', $game->next_chance, 'Mismatch of next chance');
        // // dump("{$card} - Done");
        // $b2 = $handDeck;

        // // $games = Game::all();
        // // foreach ($games as $game) {
        // //     $finalscore = 0;
        // //     $finalDehlascore = 0;
        // //     foreach($game->score as $position => $score) {
        // //         $finalscore = $finalscore + $score;
        // //     }
        // //     foreach($game->dehla_score as $position => $score) {
        // //         $finalDehlascore = $finalDehlascore + strlen($score);
        // //     }

        // //     dump()

        // // }


        // // $a1 = ["2C", "JC", "KC"];
        // // $a2 = ["4H", "JH", "QH"];
        // // $b1 = ["KS", "QD", "AD"];
        // // $b2 = ["6C", "8C", "9C"];


        // $card = '4H';
        // $handDeck = $a2;
        // $playBy = $user3;
        // $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
        // $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
        // $handDeck = array_diff($handDeck, [$card]);
        // $stake = array_merge($stake, [$card]);
        // $game = $room->getLatestGame();
        // $this->assertEquals(array_values($game->a2), array_values($handDeck), 'Mismatch of hand deck');
        // $this->assertEquals('HC', $game->dehla_score["b1"], 'Mismatch of score');
        // $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
        // // dump("{$card} - Done");
        // $a2 = $handDeck;

        // $card = '6C';
        // $handDeck = $b2;
        // $playBy = $user4;
        // $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
        // $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
        // $handDeck = array_diff($handDeck, [$card]);
        // $stake = array_merge($stake, [$card]);
        // $game = $room->getLatestGame();
        // $this->assertEquals(array_values($game->b2), array_values($handDeck), 'Mismatch of hand deck');
        // $this->assertEquals('S', $game->dehla_score["a1"], 'Mismatch of score');
        // $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
        // // dump("{$card} - Done");
        // $b2 = $handDeck;


        // $card = '2C';
        // $handDeck = $a1;
        // $playBy = $user1;
        // $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
        // $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
        // $handDeck = array_diff($handDeck, [$card]);
        // $stake = array_merge($stake, [$card]);
        // $game = $room->getLatestGame();
        // $this->assertEquals(array_values($game->a1), array_values($handDeck), 'Mismatch of hand deck');
        // $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
        // // dump("{$card} - Done");
        // $a1 = $handDeck;

        // $card = 'QD';
        // $handDeck = $b1;
        // $playBy = $user2;
        // $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
        // $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
        // $handDeck = array_diff($handDeck, [$card]);
        // $stake = [];
        // $game = $room->getLatestGame();
        // $this->assertEquals(array_values($game->b1), array_values($handDeck), 'Mismatch of hand deck');
        // $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
        // $this->assertEquals('b2', $game->next_chance, 'Mismatch of next chance');
        // // dump("{$card} - Done");
        // $b1 = $handDeck;

        
        // // $a1 = ["JC", "KC"];
        // // $a2 = ["JH", "QH"];
        // // $b1 = ["KS", "AD"];
        // // $b2 = ["8C", "9C"];


        // $card = '8C';
        // $handDeck = $b2;
        // $playBy = $user4;
        // $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
        // $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
        // $handDeck = array_diff($handDeck, [$card]);
        // $stake = array_merge($stake, [$card]);
        // $game = $room->getLatestGame();
        // $this->assertEquals(array_values($game->b2), array_values($handDeck), 'Mismatch of hand deck');
        // $this->assertEquals('S', $game->dehla_score["a1"], 'Mismatch of score');
        // $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
        // // dump("{$card} - Done");
        // $b2 = $handDeck;


        // $card = 'JC';
        // $handDeck = $a1;
        // $playBy = $user1;
        // $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
        // $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
        // $handDeck = array_diff($handDeck, [$card]);
        // $stake = array_merge($stake, [$card]);
        // $game = $room->getLatestGame();
        // $this->assertEquals(array_values($game->a1), array_values($handDeck), 'Mismatch of hand deck');
        // $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
        // // dump("{$card} - Done");
        // $a1 = $handDeck;

        // $card = 'KS';
        // $handDeck = $b1;
        // $playBy = $user2;
        // $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
        // $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
        // $handDeck = array_diff($handDeck, [$card]);
        // $stake = array_merge($stake, [$card]);
        // $game = $room->getLatestGame();
        // $this->assertEquals(array_values($game->b1), array_values($handDeck), 'Mismatch of hand deck');
        // $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
        // // dump("{$card} - Done");
        // $b1 = $handDeck;

        // $card = 'JH';
        // $handDeck = $a2;
        // $playBy = $user3;
        // $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
        // $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
        // $handDeck = array_diff($handDeck, [$card]);
        // $stake = [];
        // $game = $room->getLatestGame();
        // $this->assertEquals(array_values($game->a2), array_values($handDeck), 'Mismatch of hand deck');
        // $this->assertEquals('HC', $game->dehla_score["b1"], 'Mismatch of score');
        // $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
        // $this->assertEquals('a1', $game->next_chance, 'Mismatch of next chance');
        // // dump("{$card} - Done");
        // $a2 = $handDeck;

        // // $a1 = ["KC"];
        // // $a2 = ["QH"];
        // // $b1 = ["AD"];
        // // $b2 = ["9C"];


        // $card = 'KC';
        // $handDeck = $a1;
        // $playBy = $user1;
        // $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
        // $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
        // $handDeck = array_diff($handDeck, [$card]);
        // $stake = array_merge($stake, [$card]);
        // $game = $room->getLatestGame();
        // $this->assertEquals(array_values($game->a1), array_values($handDeck), 'Mismatch of hand deck');
        // $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
        // // dump("{$card} - Done");
        // $a1 = $handDeck;

        // $card = 'AD';
        // $handDeck = $b1;
        // $playBy = $user2;
        // $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
        // // dump($res5);
        // $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
        // $handDeck = array_diff($handDeck, [$card]);
        // $stake = array_merge($stake, [$card]);
        // $game = $room->getLatestGame();
        // $this->assertEquals(array_values($game->b1), array_values($handDeck), 'Mismatch of hand deck');
        // $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
        // // dump("{$card} - Done");
        // $b1 = $handDeck;

        // $card = 'QH';
        // $handDeck = $a2;
        // $playBy = $user3;
        // $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
        // $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
        // $handDeck = array_diff($handDeck, [$card]);
        // $stake = array_merge($stake, [$card]);
        // $game = $room->getLatestGame();
        // $this->assertEquals(array_values($game->a2), array_values($handDeck), 'Mismatch of hand deck');
        // $this->assertEquals('HC', $game->dehla_score["b1"], 'Mismatch of score');
        // $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
        // // dump("{$card} - Done");
        // $a2 = $handDeck;

        // $card = '8C';
        // $handDeck = $b2;
        // $playBy = $user4;
        // $res5 = $this->apiAs($playBy, 'post', '/api/room/' . $roomCode . '/play', ['card' => $card]);
        // $this->assertEquals(Response::HTTP_OK, $res5->getStatusCode(), 'Mismatch of status code');
        // $handDeck = array_diff($handDeck, [$card]);
        // $stake = array_merge($stake, [$card]);
        // $game = $room->getLatestGame();
        // $this->assertEquals(array_values($game->b2), array_values($handDeck), 'Mismatch of hand deck');
        // $this->assertEquals('S', $game->dehla_score["a1"], 'Mismatch of score');
        // $this->assertEquals($game->stake, $stake, 'Mismatch of stack deck');
        // dump("{$card} - Done");
        // $b2 = $handDeck;


        // $games = $room->games;

        // foreach ($games as $roomGame) {
        //     dump($roomGame->getAttributes());
        //     dump($roomGame->next_chance);
        // }

        // dump($game);
    }


}

