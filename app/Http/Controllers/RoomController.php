<?php

namespace App\Http\Controllers;

use App\Http\Transformers\RoomTransformer;
use App\Http\Transformers\UserTransformer;
use App\Room;
use App\Services\GameService;
use App\Services\RoomService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use League\Fractal\Manager;
use Symfony\Component\HttpFoundation\Response;


class RoomController extends Controller
{
    /**
     * @var RoomService
     */
    private $roomService;

    /**
     * @var
     */
    private $gameService;

    /**
     * RoomController constructor.
     * @param Manager $manager
     * @param RoomService $roomService
     * @param GameService $gameService
     */
    public function __construct(Manager $manager, RoomService $roomService, GameService $gameService)
    {
        parent::__construct($manager);
        $this->roomService = $roomService;
        $this->gameService = $gameService;
    }

    private function getError(): string
    {
        return $this->roomService->getErrors();
    }

    /**
     * @return JsonResponse
     */
    public function create()
    {
        $room = $this->roomService->createRoom(Auth::user());
        return $this->renderJson($room, new RoomTransformer());
    }

    /**
     * @param string $roomCode
     * @return JsonResponse
     */
    public function join(string $roomCode)
    {
        $room = Room::whereCode($roomCode)->firstOrFail();
        $canJoin = $this->roomService->canJoinRoom($room, Auth::user());

        if (!$canJoin) {
            return $this->renderErrors($this->getError(), Response::HTTP_BAD_REQUEST);
        }

        $this->roomService->joinRoom($room, Auth::user());
        return $this->renderJson($room, new RoomTransformer());
    }

    /**
     * @param string $roomCode
     * @return JsonResponse
     */
    public function start(string $roomCode)
    {
        $room = Room::whereCode($roomCode)->firstOrFail();
        $canStart = $this->roomService->canStartRoom($room, Auth::user());

        if (!$canStart) {
            return $this->renderErrors($this->getError(), Response::HTTP_BAD_REQUEST);
        }

        $this->roomService->startRoom($room);
        $this->gameService->createGame($room);
        return $this->renderJson($room, new RoomTransformer());
    }

    /**
     * @param string $roomCode
     * @return JsonResponse
     */
    public function getJoinedUsers(string $roomCode)
    {
        $room = Room::whereCode($roomCode)->firstOrFail();
        $users = $room->users;
        $this->setParseIncludes(['room_users']);
        return $this->renderJsonArray($users, new UserTransformer($room->code));
    }
}
