<?php

namespace App\Http\Controllers;

use App\Room;
use App\Services\GameService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use League\Fractal\Manager;
use Symfony\Component\HttpFoundation\Response;

class GameController extends Controller
{

    private $gameService;

    /**
     * GameController constructor.
     * @param Manager $manager
     * @param GameService $gameService
     */
    public function __construct(Manager $manager, GameService $gameService)
    {
        parent::__construct($manager);
        $this->gameService = $gameService;
    }

    /**
     * @return string
     */
    public function getError(): string
    {
        return $this->gameService->getErrors();
    }

    /**
     * @param string $roomCode
     * @return JsonResponse
     */
    public function initialCards(string $roomCode)
    {
        $room = Room::whereCode($roomCode)->firstOrFail();
        $game = $room->game;
        $canProvideInitialCards = $this->gameService->canProvideInitialCards($room, Auth::user());

        if (!$canProvideInitialCards) {
            return $this->renderErrors($this->getError(), Response::HTTP_BAD_REQUEST);
        }

        $initialCards = $this->gameService->getInitialCards($game, Auth::user());
        $nextChancePosition = $game->getNextChancePosition();
        $previousGame = $game->getPreviousGame();
        $data = [
            'initialCards' => $initialCards,
            'oldStake' => $previousGame ? $previousGame->stake : [],
            'initialStake' => $game->stake,
            'nextChance' => $nextChancePosition,
            'oldStakeFirstChance' => $previousGame ? $previousGame->getSimpleNextPosition() : '',
        ];
        return response()->json($data, 200);
    }

    /**
     * @param Request $request
     * @param string $roomCode
     * @return JsonResponse
     */
    public function play(Request $request, string $roomCode)
    {
        $room = Room::whereCode($roomCode)->firstOrFail();
        $card = $request->get('card');
        $user = Auth::user();

        $canPlayInRoom = $this->gameService->canPlayInRoom($room, $user);
        if (!$canPlayInRoom) {
            return $this->renderErrors($this->getError(), Response::HTTP_BAD_REQUEST);
        }

        $canPlayThisCard = $this->gameService->canPlayThisCard($room, $user, $card);
        if (!$canPlayThisCard) {
            return $this->renderErrors($this->getError(), Response::HTTP_BAD_REQUEST);
        }

        $this->gameService->play($room, $user, $card);
        return response()->json([], 200);
    }

    /**
     * @param string $roomCode
     * @return JsonResponse
     */
    public function openTrumpCard(string $roomCode)
    {
        $room = Room::whereCode($roomCode)->firstOrFail();
        $user = Auth::user();
        $game = $room->getLatestGame();

        $canPlayInRoom = $this->gameService->canPlayInRoom($room, $user);
        if (!$canPlayInRoom) {
            return $this->renderErrors($this->getError(), Response::HTTP_BAD_REQUEST);
        }
        
        $canOpenTrumpCard = $this->gameService->canOpenTrumpCard($room, $user, $game);
        if (!$canOpenTrumpCard) {
            return $this->renderErrors($this->getError(), Response::HTTP_BAD_REQUEST);
        }

        $this->gameService->openTrumpCard($room, $user, $game);        
        return response()->json([], 200);
    }

    /**
     * @param string $roomCode
     * @return JsonResponse
     */
    public function getScores(string $roomCode)
    {
        $room = Room::whereCode($roomCode)->firstOrFail();
        $score = $this->gameService->getScore($room);
        return response()->json($score, 200);
    }
}
