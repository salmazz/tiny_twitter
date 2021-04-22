<?php

namespace App\Http\Controllers;

use App\Services\ReportService;
use PDF;


class ReportController extends Controller
{
    /**
     * @var ReportService
     */
    public $reportService;

    /**
     * UserService constructor.
     * @param ReportService $tweetService
     */
    public function __construct(ReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    /**
     * Get report of tweets count per users and average
     *
     * @return array
     */
    public function report()
    {
        $report = $this->reportService->report();

        $pdf = PDF::loadView('pdf', $report);

         return $pdf->stream('report.pdf');
    }
}
