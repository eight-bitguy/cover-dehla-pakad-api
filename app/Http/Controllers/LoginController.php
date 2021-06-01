<?php

namespace App\Http\Controllers;

use App\Http\ResponseErrors;
use App\Http\Transformers\UserTransformer;
use App\Services\LoginService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use League\Fractal\Manager;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{

    private $loginService;

    /**
     * LoginController constructor.
     * @param Manager $manager
     * @param LoginService $loginService
     */
    public function __construct(Manager $manager, LoginService $loginService)
    {
        parent::__construct($manager);
        $this->loginService = $loginService;
    }

    /**
     * Function for login
     *
     * @param Request $request Request
     *
     * @return Response
     */
    public function login(Request $request): Response
    {
        $credentials = $request->only('email', 'password');
        $user = $this->loginService->login($credentials);

        if (!$user) {
            return $this->renderErrors($this->loginService->getErrors(), Response::HTTP_BAD_REQUEST);
        }

        return $this->renderJson($user, new UserTransformer());
    }

}
