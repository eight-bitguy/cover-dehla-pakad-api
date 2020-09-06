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

        $game = new Game();
        $game->score = ['a1' => 0, 'b1' => 0, 'a2' => 0, 'b2' => 0];
        $game->room_id = $room->id;
        $game->stake = [];
        $game->next_chance = Room::POSITION_A1;

        $shuffledCard = $this->cardService->getShuffledCards();
        $game[Room::POSITION_A1] = $shuffledCard[Room::POSITION_A1];
        $game[Room::POSITION_A2] = $shuffledCard[Room::POSITION_A2];
        $game[Room::POSITION_B1] = $shuffledCard[Room::POSITION_B1];
        $game[Room::POSITION_B2] = $shuffledCard[Room::POSITION_B2];

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

        if ($room->getUserPositionInRoom($user->id) !== $room->game->next_chance) {
            $this->errors[] = [[$room->game->toArray(), $room->getUserPositionInRoom($user->id)]];
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
        $game = $room->game;
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
     * @return Game
     */
    public function checkForTrump(Game $game)
    {
        $isTrumpDecided = $game->trump;
        if ($isTrumpDecided) {
            return $game;
        }

        $stake = $game->stake;
        $firstCardIndex = 0;
        $chanceOfDeck = $stake[$firstCardIndex][Card::DECK_INDEX];

        array_walk($stake, function ($card) use (&$game, $chanceOfDeck){
            $isTrumpDecided = $game->trump_from_next_iteration;
            $potentialTrumpCard = $chanceOfDeck !== $card[Card::DECK_INDEX];
            if (!$isTrumpDecided && $potentialTrumpCard) {
                $game->trump_from_next_iteration = $card[Card::DECK_INDEX];
                $game->trump_decided_by = $game->played_by;
            }
        });

        return $game;
    }

    /**
     * @param Room $room
     * @param User $user
     * @param string $card
     */
    public function play(Room $room, User $user, string $card)
    {
        $game = $room->game;
        $nextGame = $game->replicate();

        $userPosition = $room->getUserPositionInRoom($user->id);
        $nextGame = $this->moveCardToStake($nextGame, $userPosition, $card);

        $nextGame->played_by = $userPosition;
        $nextGame = $this->checkForTrump($nextGame);

        if ($this->isIterationCompleted($nextGame)) {
            $nextGame->next_chance = null;
            $nextGame->save();
            $nextGame = $this->processIteration($nextGame);
            $nextGame->save();
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
     * @param Game $nextGame
     * @param Game $oldGame
     * @param string $winnerPosition
     * @return Game
     */
    public function handleDehlaInStake(Game $nextGame, Game $oldGame, string $winnerPosition)
    {
        $dehlaInStake = $this->isDehlaInStake($oldGame->stake);

        if ($dehlaInStake || $nextGame->dehla_on_stake) {
            $nextGame->claming_by = $winnerPosition;
        }

        if ($dehlaInStake) {
            $nextGame->dehla_on_stake = $nextGame->dehla_on_stake + $dehlaInStake;
            return $nextGame;
        }

        $hasConsecutivelyClaimed = $oldGame->claming_by === $winnerPosition;
        if ($hasConsecutivelyClaimed) {
            $nextGame = $this->updateScore($nextGame, $winnerPosition);
            $nextGame->claming_by = null;
            $nextGame->dehla_on_stake = 0;
        }
        return $nextGame;
    }

    /**
     * @param Game $nextGame
     * @param Game $oldGame
     * @return Game
     */
    public function createTrumpIfPossible(Game $nextGame, Game $oldGame)
    {
        if ($oldGame->trump_from_next_iteration) {
            $nextGame->trump = $oldGame->trump_from_next_iteration;
            $nextGame->trump_from_next_iteration = null;
            $nextGame->next_chance = $oldGame->trump_decided_by;
            $nextGame->claming_by = ($this->isDehlaInStake($oldGame->stake) || $oldGame->dehla_on_stake) ?
                $oldGame->trump_decided_by : null;
        }

        return $nextGame;
    }

    /**
     * @param Game $oldGame
     * @return Game
     */
    public function processIteration(Game $oldGame)
    {
        $nextGame = $oldGame->replicate();
        $nextGame->played_by = null;
        $highestCard = $this->cardService->getHighestCardFromDifferentDecks($oldGame->stake, $oldGame->trump);

        $winnerPosition = $this->getPositionOfCardUser($nextGame, $highestCard, $oldGame->played_by);
        $nextGame->next_chance = $winnerPosition;

        $nextGame = $this->handleDehlaInStake($nextGame, $oldGame, $winnerPosition);
        $nextGame = $this->emptyStake($nextGame);
        $nextGame = $this->createTrumpIfPossible($nextGame, $oldGame);

        $nextGame->created_at = Carbon::now()->addSecond();

        return $nextGame;
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
    public function isDehlaInStake(array $cards)
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
    public function updateScore(Game $game, string $winnerPosition): Game
    {
       $score = $game->score;
       $score[$winnerPosition] = $score[$winnerPosition] + $game->dehla_on_stake;
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
