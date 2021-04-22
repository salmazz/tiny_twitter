<?php

namespace App\Services;

use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\RegisterRequest;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class UserService
{
    /**
     * @var UserRepository
     */
    public $userRepository;

    /**
     * Specify repository class name
     *
     * @return string
     */
    public function repository()
    {
        return UserRepository::class;
    }

    /**
     * UserRepository constructor.
     * @param UserRepository $userRepository
     */
    public function __construct()
    {
        $this->userRepository = app($this->repository());
    }

    /**
     * @param RegisterRequest $request
     * @return array
     */
    public function register(RegisterRequest $request)
    {
        $data = array_merge($request->only('name', 'email', 'date_of_birth'), ['password' => bcrypt($request->password)]);

        $user = $this->userRepository->create($data);

        if($request->hasFile('avatar')) {
            $user->addMedia($request->avatar)->toMediaCollection('avatars');
        }

        $token = $user->createToken('TinyTwitter')->accessToken;

        return ['token' => $token, 'user' => $user];
    }

    /**
     * @param LoginRequest $request
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $this->checkTooManyFailedAttempts();

        $credentials = $request->only('email', 'password');

        if(Auth::attempt($credentials)){
            $user = Auth::user();
            $token =  $user->createToken('TinyTwitter')-> accessToken;
            RateLimiter::clear($this->throttleKey());
            return ['token' => $token, 'user' => $user ];
        }
        else{
            RateLimiter::hit($this->throttleKey(), $seconds = 3600);
            throw new \Exception("Un auth");
        }
    }

    /**
     * Get the rate limiting throttle key for the request.
     *
     * @return string
     */
    public function throttleKey()
    {
        return Str::lower(request('email')) . '|' . request()->ip();
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @return void
     */
    public function checkTooManyFailedAttempts()
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        throw new \Exception('IP address banned. Too many login attempts.');
    }
}
