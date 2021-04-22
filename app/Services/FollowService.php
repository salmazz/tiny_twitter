<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\FollowRepository;

class FollowService
{
    /**
     * @var FollowRepository
     */
    public $followRepository;

    /**
     * Specify repository class name
     *
     * @return string
     */
    public function repository()
    {
        return FollowRepository::class;
    }

    /**
     * Follow
     *
     * @param $id
     * @return bool
     * @throws \Exception
     */
    public function follow($id)
    {
        try{
            // Find the User. Redirect if the User doesn't exist
            $user = User::where('id', $id)->where('id',"!=",auth()->user()->id)->firstOrFail();

            // Follow
            auth()->user()->following()->syncWithoutDetaching($user->id);
        }catch (\Exception $exception){
            throw new \Exception($exception->getMessage());
        }

        return true;
    }

    /**
     * Unfollow
     *
     * @param $id
     * @return bool
     * @throws \Exception
     */
    public function unfollow($id)
    {
        try{
            // Find the User. Redirect if the User doesn't exist
            $user = User::where('id', $id)->firstOrFail();

            // Unfollow
            auth()->user()->following()->detach($user->id);
        }catch (\Exception $exception){
            throw new \Exception($exception->getMessage());
        }

        return true;
    }
}
