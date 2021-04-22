<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\RegisterRequest;
use App\Http\Resources\User\UserResource;
use App\Services\UserService;
use Illuminate\Http\Request;
use Laravel\Passport\Http\Controllers\AccessTokenController;

class PassportAuthController extends Controller
{
    /**
     * @var UserService
     */
    public $userService;

    protected $maxLoginAttempts = 5; // Amount of bad attempts user can make
    protected $lockoutTime = 300; // Time for which user is going to be blocked in seconds

    /**
     * UserService constructor.
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Register
     *
     * @param RegisterRequest $request
     * @return UserResource|\Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        try {
            $response = $this->userService->register($request);
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 401);
        }

        return (new UserResource($response['user']))->additional(['token' => $response['token']]);
    }

    /**
     * Login
     *
     * @param Request $request
     * @return UserResource|\Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        try {
            $response = $this->userService->login($request);
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 401);
        }

        return (new UserResource($response['user']))->additional(['token' => $response['token']]);
    }
}
