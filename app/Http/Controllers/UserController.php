<?php

namespace App\Http\Controllers;

use App\Http\Resources\User\UserCollection;
use App\Services\UserService;

class UserController extends Controller
{
    /**
     * @var UserService
     */
    public $userService;

    /**
     * User constructor.
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(){
        $users = $this->userService->allUsers();

        return new UserCollection($users);
    }
}
