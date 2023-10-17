<?php

namespace App\Services;

use App\Card;
use App\Room;
use App\User;
use Illuminate\Support\Facades\DB;

class TestService
{
    /**
     * @var GameService
     */
    private $gameService;

    public function __construct(GameService $gameService)
    {
        $this->gameService = $gameService;
    }

    /**
     * @param string $roomId
     */
    public function play(string $roomId)
    {
        $room = Room::find($roomId);
        $game = $room->game;
        $suitInUse = count($game->stake) ? $game->stake[0][Card::DECK_INDEX] : null;

        $nextChance = $game->next_chance;
        $possibleCardsToPlay = $suitInUse ? array_filter($game->$nextChance, function($card) use ($suitInUse) {
            return $card[Card::DECK_INDEX] == $suitInUse;
        }) : $game->$nextChance;

        if (count($possibleCardsToPlay)==0) {
            $possibleCardsToPlay = $game->$nextChance;
        }
        $possibleCardsToPlay = array_values($possibleCardsToPlay);

        $cardToPlay = $possibleCardsToPlay[rand(0, count($possibleCardsToPlay) -1)];
        $userId = DB::table('room_users')->whereRoomId($room->id)->wherePosition($nextChance)->first();
        $user = User::find($userId->user_id);
        $this->gameService->play($room, $user, $cardToPlay);
    }
}
