<?php

namespace App\Services;

use App\Card;
use App\Events\BroadcastNewGameEvent;
use App\Game;
use App\Http\ResponseErrors;
use App\Room;
use App\User;
use Carbon\Carbon;

/**
 * Class GameService
 *
 * @package App\Services
 */
class GameService extends Service
{

    /**
     * @var CardService
     */
    private $cardService;

    public function __construct(CardService $cardService)
    {
        $this->cardService = $cardService;
    }

    /**
     * @param Room $room
     * @param User $user
     *
     * @return bool
     */
    public function canProvideInitialCards(Room $room, User $user): bool
    {
        if (!$room->isActive()) {
            $this->errors[] = ResponseErrors::ROOM_IS_NOT_ACTIVE;
            return false;
        }

        if (!$room->isUserPresentInTheRoom($user)) {
            $this->errors[] = ResponseErrors::USER_NOT_PRESENT_IN_ROOM;
            return false;
        }

        return true;
    }

    public function canOpenTrumpCard(Room $room, User $user, Game $game): bool
    {
        $userPositionInRoom = $room->getUserPositionInRoom($user->id);
        if ($game->trump_hidden_by == $userPositionInRoom) {
            $this->errors[] = ResponseErrors::USER_CANNOT_OPEN_TRUMP;
            return false;
        }
        return true;
    }

    public function openTrumpCard(Room $room, User $user, Game $game): bool
    {
        $nextGame = $game->replicate();

        $userPosition = $room->getUserPositionInRoom($user->id);
        $nextGame = $this->moveTrumpCardToHandDeck($nextGame);
        $nextGame->trump_decided_by = $userPosition;
        $nextGame->trump_from_next_iteration = $nextGame->trump;
        $nextGame->save();

        $this->broadcastGameEvents($nextGame);
        return true;
    }

    /**
     * @param Game $game
     * @param User $user
     *
     * @return array
     */
    public function getInitialCards(Game $game, User $user): array
    {
        $userPosition = $game->getUserPosition($user);
        return $game[$userPosition];
    }

    /**
     * @param Room $room
     */
    public function createGame(Room $room)
    {
        if ($room->game) {
            return;
        }

        $trumpHiddenBy = Room::POSITION_A1;

        $game = new Game();
        $game->dehla_score = ['a1' => 0, 'b1' => 0, 'a2' => 0, 'b2' => 0];
        $game->score = ['a1' => 0, 'b1' => 0, 'a2' => 0, 'b2' => 0];
        $game->room_id = $room->id;
        $game->stake = [];
        $game->next_chance = Room::POSITION_A1;
        $game->trump_hidden_by = $trumpHiddenBy;

        $shuffledCard = $this->cardService->getShuffledCards();
        $game[Room::POSITION_A1] = $shuffledCard[Room::POSITION_A1];
        $game[Room::POSITION_A2] = $shuffledCard[Room::POSITION_A2];
        $game[Room::POSITION_B1] = $shuffledCard[Room::POSITION_B1];
        $game[Room::POSITION_B2] = $shuffledCard[Room::POSITION_B2];
        
        $handDeck = $game->$trumpHiddenBy;
        $game->trump = array_pop($handDeck);
        $game->$trumpHiddenBy = $handDeck;
        // $newCardList = array_values(array_diff($userCards, [$card]));
        $game->save();
    }

    /**
     * @param Room $room
     * @param User $user
     *
     * @return bool
     */
    public function canPlayInRoom(Room $room, User $user)
    {
        if (!$room->isActive()) {
            $this->errors[] = ResponseErrors::ROOM_IS_NOT_ACTIVE;
            return false;
        }

        if (!$room->isUserPresentInTheRoom($user)) {
            $this->errors[] = ResponseErrors::USER_NOT_PRESENT_IN_ROOM;
            return false;
        }

        $game = $room->getLatestGame();
        if ($room->getUserPositionInRoom($user->id) !== $game->next_chance) {
            $this->errors[] = ResponseErrors::NO_USER_CHANCE;
            return false;
        }

        return true;
    }

    /**
     * @param Room $room
     * @param User $user
     * @param string $card
     *
     * @return bool
     */
    public function cardPresentWithUser(Room $room, User $user, string $card)
    {
        $game = $room->getLatestGame();
        $userPosition = $room->getUserPositionInRoom($user->id);
        return in_array($card, $game->$userPosition);
    }

    /**
     * @param Room $room
     * @param User $user
     * @param string $card
     *
     * @return bool
     */
    public function canPlayThisCard(Room $room, User $user, string $card)
    {
        if (!Card::isValid($card)) {
            $this->errors[] = ResponseErrors::INVALID_CARD;
            return false;
        }

        if (!$this->cardPresentWithUser($room, $user, $card)) {
            $this->errors[] = ResponseErrors::CARD_NOT_PRESENT_WITH_USER;
            return false;
        }

        return true;
    }

    /**
     * @param Game $game
     * @param string $position
     * @param string $card
     *
     * @return Game
     */
    public function moveCardToStake(Game $game, string $position, string $card)
    {
        $userCards = $game->$position;
        $newCardList = array_values(array_diff($userCards, [$card]));

        $cardsOnStake = $game->stake;
        array_push($cardsOnStake, $card);

        $game->$position = $newCardList;
        $game->stake = $cardsOnStake;

        return $game;
    }

    /**
     * @param Game $game
     *
     * @return Game
     */
    public function moveTrumpCardToHandDeck(Game $game)
    {
        $trumpHiddenBy = $game->trump_hidden_by;
        $userCards = $game->$trumpHiddenBy;
        array_push($userCards, $game->trump);
        
        $newCardList = array_values($userCards);
        $game->$trumpHiddenBy = $newCardList;
        $game->save();

        return $game;
    }

    /**
     * @param Room $room
     * @param User $user
     * @param string $card
     */
    public function play(Room $room, User $user, string $card)
    {
        $game = $room->getLatestGame();
        $nextGame = $game->replicate();

        $userPosition = $room->getUserPositionInRoom($user->id);
        $nextGame = $this->moveCardToStake($nextGame, $userPosition, $card);

        $nextGame->played_by = $userPosition;

        if ($this->isIterationCompleted($nextGame)) {
            $nextGame->next_chance = null;
            $nextGame->save();
            $nextGame = $this->processIteration($nextGame);
        }
        else {
            $nextGame->next_chance = $nextGame->getNextChancePosition();
        }
        $nextGame->save();

        $this->broadcastGameEvents($nextGame);
    }

    /**
     * @param Game $game
     */
    public function broadcastGameEvents(Game $game)
    {
        $allHandsEmpty = true;
        $allPositions = Room::ALL_POSITIONS;

        array_walk($allPositions, function($position) use (&$allHandsEmpty, $game) {
            $allHandsEmpty = $allHandsEmpty && (count($game->$position) == 0);
        });

        if ($allHandsEmpty) {
            $room = $game->room;
            $room->status = Room::ROOM_STATUS_INACTIVE;
            $room->save();
        }

        broadcast(new BroadcastNewGameEvent($game));
    }

    /**
     * @param Game $oldGame
     * @return Game
     */
    public function processIteration(Game $oldGame)
    {
        $nextGame = $oldGame->replicate();
        $nextGame->played_by = null;

        $winnerPosition = $this->getPositionOfHighestCard($oldGame, $nextGame);
        $nextGame->next_chance = $winnerPosition;

        $dehlaCount = $this->dehlaCountInStake($oldGame->stake);
        $nextGame = $this->updateScore($nextGame, $winnerPosition, $dehlaCount);
        $nextGame->save();
        $nextGame = $this->emptyStake($nextGame);

        $nextGame->created_at = Carbon::now()->addSecond();

        return $nextGame;
    }

    /**
     * @param Game $oldGame
     * @param Game $nextGame
     * @return bool|mixed
     */
    public function getPositionOfHighestCard(Game $oldGame, Game $nextGame)
    {
        $trump = $oldGame->trump_decided_by ? $oldGame->trump : null;
        $highestCard = $this->cardService->getHighestCardFromDifferentDecks($oldGame->stake, $trump);

        return $this->getPositionOfCardUser($nextGame, $highestCard, $oldGame->played_by);
    }

    /**
     * @param Game $game
     * @return Game
     */
    public function emptyStake(Game $game)
    {
        $game->stake = [];
        return $game;
    }

    /**
     * @param Game $game
     * @return bool
     */
    public function isIterationCompleted(Game $game): bool
    {
        $countOfCardsInStake = count($game->stake);
        return $countOfCardsInStake == 4;
    }

    /**
     * @param Game $game
     * @param string $card
     * @param string $lastPlayedBy
     * @return bool|mixed
     */
    public function getPositionOfCardUser(Game $game, string $card, string $lastPlayedBy)
    {
        $maxCardIndex = array_search($card, $game->stake);
        $currentPositionIndex = array_search($game->played_by, Room::ALL_POSITIONS);
        $lastPlayedByIndex = array_search($lastPlayedBy, Room::ALL_POSITIONS);

        return Room::ALL_POSITIONS[($maxCardIndex + 1 + $currentPositionIndex + $lastPlayedByIndex) % 4];
    }

    /**
     * @param array $cards
     * @return int
     */
    public function dehlaCountInStake(array $cards)
    {
        $dehla = 0;
        foreach ($cards as $card) {
            $isDehla = $card[Card::RANK_INDEX] === Card::RANK_TEN;
            if ($isDehla) {
                $dehla = $dehla+1;
            }
        }
        return $dehla;
    }

    /**
     * @param Game $game
     * @param string $winnerPosition
     * @return Game
     */
    public function updateScore(Game $game, string $winnerPosition, int $dehlaInStake): Game
    {
        if ($dehlaInStake) {
            $score = $game->dehla_score;
            $score[$winnerPosition] = $score[$winnerPosition] + $dehlaInStake;
            $game->dehla_score = $score;
            return $game;
        }
        $score = $game->score;
        $score[$winnerPosition] = $score[$winnerPosition] + 1;
        $game->score = $score;
        return $game;
    }

    /**
     * @param Room $room
     * @return array
     */
    public function getScore(Room $room): array
    {
        $game = $room->game;
        $scores = [];
        foreach ($room->users as $user) {
            $position = $user['pivot']['position'];
            $scores[$position] = [
                'name' => $user->name,
                'score' => $game->score[$position]
            ];
        }

        return $scores;
    }

}
