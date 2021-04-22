<?php

namespace App\Services;

use App\Models\Tweet;
use App\Models\User;
use App\Repositories\ReportRepository;
use PDF;

class ReportService
{
    /**
     * @var ReportRepository
     */
    public $reportRepository;

    /**
     * Specify repository class name
     *
     * @return string
     */
    public function repository()
    {
        return ReportRepository::class;
    }

    public function report()
    {
        $tweet_count = Tweet::count();
        $user_count = User::count();

        $average = $user_count > 0 && $tweet_count > 0 ? round(Tweet::count() / User::count(),0) : 0;

        $users = User::withCount('tweets')->get();

        return ['users' => $users, 'average' => $average];
    }


}
