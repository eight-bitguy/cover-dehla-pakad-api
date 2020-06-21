<?php

namespace App\Http\Controllers;

use App\Http\Transformers\UserTransformer;
use App\Services\UserService;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use League\Fractal\Manager;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{

    /**
     * @var UserService
     */
    private $userService;

    /**
     * RegisterController constructor.
     *
     * @param Manager $manager
     * @param UserService $userService
     */
    public function __construct(Manager $manager, UserService $userService)
    {
        parent::__construct($manager);
        $this->userService = $userService;
    }

    /**
     * @return JsonResponse
     */
    public function me()
    {
        $user = Auth::user();
        return $this->renderJson($user, new UserTransformer());
    }

    /**
     * Register new User
     *
     * @param Request $request
     *
     * @return Response
     */
    public function create(Request $request): Response
    {
        $userDetails = $this->getParams($request);
        $user = $this->userService->register($userDetails);
        if (!$user) {
            return response()->json($this->userService->getErrors(), Response::HTTP_BAD_REQUEST);
        }
        return $this->renderJson($user, new UserTransformer(), Response::HTTP_CREATED);
    }

    /**
     * @param Request $request
     * @return array
     */
    public function getParams(Request $request): array
    {
        return [
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
        ];
    }

}
