<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;
use Illuminate\Support\Facades\DB;

/**
 * @OA\Tag(
 *     name="Home",
 *     description="Operations related to the home page and job statistics"
 * )
 */

class HomeController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/home",
     *     summary="Get job statistics and charts data",
     *     description="Retrieve job statistics data including job types, job counts by month, and job titles with counts.",
     *     tags={"Home"},
     *     security={{"sanctum": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Job statistics data retrieved successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="job_type_data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="job_type", type="string", example="Full-time"),
     *                     @OA\Property(property="count", type="integer", example=10)
     *                 )
     *             ),
     *             @OA\Property(
     *                 property="jobs_by_month",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="month", type="string", example="January"),
     *                     @OA\Property(property="count", type="integer", example=15)
     *                 )
     *             ),
     *             @OA\Property(
     *                 property="months",
     *                 type="array",
     *                 @OA\Items(
     *                     type="string",
     *                     example="January"
     *                 )
     *             ),
     *             @OA\Property(
     *                 property="job_title_data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="title", type="string", example="Software Engineer"),
     *                     @OA\Property(property="count", type="integer", example=5)
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Unauthorized")
     *         )
     *     )
     * )
     */
    public function index()
    {
        // Fetch the data for job types
        $jobTypeData = Job::select('job_type', DB::raw('count(*) as count'))
            ->groupBy('job_type')
            ->get();

        // Fetch jobs by month
        $jobsByMonth = Job::select(DB::raw('MONTH(created_at) as month'), DB::raw('count(*) as count'))
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->get();

        // Convert month numbers to names
        $months = $jobsByMonth->pluck('month')->map(function ($m) {
            return date('F', mktime(0, 0, 0, $m, 1));
        });

        // Fetch job titles with counts
        $jobTitleData = Job::select('title', DB::raw('count(*) as count'))
            ->groupBy('title')
            ->get();

        // Return JSON response
        return response()->json([
            'job_type_data' => $jobTypeData,
            'jobs_by_month' => $jobsByMonth,
            'months' => $months,
            'job_title_data' => $jobTitleData,
        ], 200);
    }
}
