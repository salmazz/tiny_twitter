<?php

namespace App\Services;

use App\Http\Requests\Tweet\StoreRequest;
use App\Repositories\TweetRepository;

class TweetService
{
    /**
     * @var TweetRepository
     */
    public $userRepository;

    /**
     * Specify repository class name
     *
     * @return string
     */
    public function repository()
    {
        return TweetRepository::class;
    }

    /**
     * TweetRepository constructor.
     * @param TweetRepository $userRepository
     */
    public function __construct()
    {
        $this->tweetRepository = app($this->repository());
    }

    /**
     * @return mixed
     */
    public function create(StoreRequest $request)
    {
        try {
            $data = array_merge($request->only('tweet'), ['user_id' => auth()->user()->id]);

            $tweet = $this->tweetRepository->create($data);
        } catch(\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }

        return $tweet;
    }
}
