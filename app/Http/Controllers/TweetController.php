<?php

namespace App\Http\Controllers;

use App\Http\Requests\Tweet\StoreRequest;
use App\Http\Resources\Tweet\TweetResource;
use App\Services\TweetService;

class TweetController extends Controller
{
    /**
     * @var TweetService
     */
    public $tweetService;

    /**
     * UserService constructor.
     * @param TweetService $tweetService
     */
    public function __construct(TweetService $tweetService)
    {
        $this->tweetService = $tweetService;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRequest $request
     * @return TweetResource|\Illuminate\Http\JsonResponse
     */
    public function store(StoreRequest $request)
    {
        try {
            $tweet = $this->tweetService->create($request);
        } catch(\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }

        return new TweetResource($tweet);
    }
}
