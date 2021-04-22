<?php

namespace App\Http\Controllers;

use App\Services\FollowService;

class FollowController extends Controller
{
    /**
     * @var FollowService
     */
    public $followService;

    /**
     * UserService constructor.
     * @param FollowService $followService
     */
    public function __construct(FollowService $followService)
    {
        $this->followService = $followService;
    }

    /**
     * Follow
     *
     * @return \Illuminate\Http\JsonResponse|string
     */
    public function follow($id)
    {
        try {
            $this->followService->follow($id);
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }

        return response()->json(['success' => 'You Follow Successfully'], 200);
    }

    /**
     * unfollow
     *
     * @return \Illuminate\Http\JsonResponse|string
     */
    public function unfollow($id)
    {
        try {
            $this->followService->unfollow($id);
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }

        return response()->json(['success' => 'You unfollow Successfully'], 200);
    }
}
