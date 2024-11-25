<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\JobQuestion;
use Illuminate\Support\Facades\Auth;
/**
 * @OA\Tag(
 *     name="Job",
 *     description="Operations related to the user Job"
 * )
 */
/**
 * @OA\Schema(
 *     schema="Job",
 *     type="object",
 *     required={"title", "description", "job_type"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="user_id", type="integer", example=2),
 *     @OA\Property(property="title", type="string", example="Software Developer"),
 *     @OA\Property(property="description", type="string", example="Job description here..."),
 *     @OA\Property(property="location", type="string", example="Remote"),
 *     @OA\Property(property="salary", type="number", format="float", example=50000),
 *     @OA\Property(property="job_type", type="string", enum={"Full-time", "Part-time", "Contract"}, example="Full-time"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2024-11-25T12:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2024-11-25T12:00:00Z")
 * )
 */

class JobController extends Controller
{
     /**
     * @OA\Get(
     *     path="/api/jobs",
     *     summary="Get list of jobs with recommendations",
     *     description="Fetch jobs and recommended jobs based on user's profile skills.",
     *     tags={"Jobs"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="List of jobs with recommendations",
     *         @OA\JsonContent(
     *             @OA\Property(property="jobs", type="array", @OA\Items(ref="#/components/schemas/Job")),
     *             @OA\Property(property="recommended_jobs", type="array", @OA\Items(ref="#/components/schemas/Job"))
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
    public function index(Request $request)
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $jobs = Job::where('user_id', '!=', auth()->id())->paginate(10);

        if (!$user->profile || !$user->profile->skills) {
            return response()->json([
                'message' => 'Please add your skills to see recommended jobs.',
                'jobs' => $jobs
            ], 200);
        }

        $userSkills = $user->profile->skills;
        $recommendedJobs = $jobs->filter(function ($job) use ($userSkills) {
            foreach ($userSkills as $skill) {
                if (stripos($job->title, $skill) !== false || stripos($job->description, $skill) !== false) {
                    return true;
                }
            }
            return false;
        });

        return response()->json([
            'jobs' => $jobs,
            'recommended_jobs' => $recommendedJobs
        ], 200);
    }
        /**
     * @OA\Get(
     *     path="/api/company/jobs",
     *     summary="Get jobs with questions",
     *     description="Fetch jobs that have associated questions.",
     *     tags={"Jobs"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Jobs with questions",
     *         @OA\JsonContent(
     *             @OA\Property(property="jobs_with_questions", type="array", @OA\Items(ref="#/components/schemas/Job"))
     *         )
     *     )
     * )
     */
    public function companyIndex()
    {
        $jobsWithQuestions = Job::has('questions')->get();

        return response()->json(['jobs_with_questions' => $jobsWithQuestions], 200);
    }

    public function showApplicants($id)
    {
        $job = Job::find($id);

        if (!$job) {
            return response()->json(['error' => 'Job not found'], 404);
        }

        $applicants = $job->applicants;

        return response()->json(['job' => $job, 'applicants' => $applicants], 200);
    }
        /**
     * @OA\Get(
     *     path="/api/jobs/applied",
     *     summary="Get applied jobs",
     *     description="Fetch jobs that the authenticated user has applied to.",
     *     tags={"Jobs"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="List of applied jobs",
     *         @OA\JsonContent(
     *             @OA\Property(property="applied_jobs", type="array", @OA\Items(ref="#/components/schemas/Job"))
     *         )
     *     )
     * )
     */
    public function appliedJobs()
    {
        $appliedJobs = auth()->user()->appliedJobs()->get();

        return response()->json(['applied_jobs' => $appliedJobs], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/jobs/{jobId}/apply",
     *     summary="Apply for a job",
     *     description="Apply for a job if not already applied.",
     *     tags={"Jobs"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="jobId",
     *         in="path",
     *         required=true,
     *         description="Job ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successfully applied for the job",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Successfully applied for the job")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Already applied",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Already applied")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Job not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Job not found")
     *         )
     *     )
     * )
     */
    public function apply($jobId)
    {
        $job = Job::find($jobId);

        if (!$job) {
            return response()->json(['error' => 'Job not found'], 404);
        }

        if ($job->applicants()->where('user_id', auth()->id())->exists()) {
            return response()->json(['error' => 'Already applied'], 400);
        }

        $job->applicants()->attach(auth()->id());

        return response()->json(['message' => 'Successfully applied for the job'], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/jobs",
     *     summary="Post a new job",
     *     description="Create a new job listing.",
     *     tags={"Jobs"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title", "description", "job_type"},
     *             @OA\Property(property="title", type="string", example="Software Developer"),
     *             @OA\Property(property="description", type="string", example="Job description here..."),
     *             @OA\Property(property="location", type="string", example="Remote"),
     *             @OA\Property(property="job_type", type="string", enum={"Full-time", "Part-time", "Contract"}),
     *             @OA\Property(property="salary", type="number", format="float", example=50000)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Job posted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Job posted successfully"),
     *             @OA\Property(property="job", ref="#/components/schemas/Job")
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'nullable|string|max:255',
            'job_type' => 'required|in:Full-time,Part-time,Contract',
            'salary' => 'nullable|numeric',
        ]);

        $job = Job::create([
            'user_id' => Auth::id(),
            'title' => $validated['title'],
            'description' => $validated['description'],
            'location' => $validated['location'],
            'job_type' => $validated['job_type'],
            'salary' => $validated['salary'],
        ]);

        return response()->json(['message' => 'Job posted successfully', 'job' => $job], 201);
    }
     /**
     * @OA\Put(
     *     path="/api/jobs/{jobId}",
     *     summary="Update a job",
     *     description="Update an existing job listing.",
     *     tags={"Jobs"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="jobId",
     *         in="path",
     *         required=true,
     *         description="Job ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="title", type="string", example="Updated Job Title"),
     *             @OA\Property(property="description", type="string", example="Updated job description"),
     *             @OA\Property(property="location", type="string", example="New Location"),
     *             @OA\Property(property="salary", type="number", format="float", example=60000),
     *             @OA\Property(property="job_type", type="string", enum={"Full-time", "Part-time", "Contract"})
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Job updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Job updated successfully"),
     *             @OA\Property(property="job", ref="#/components/schemas/Job")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Job not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Job not found")
     *         )
     *     )
     * )
     */
    public function update(Request $request, $jobId)
    {
        $job = Job::find($jobId);

        if (!$job) {
            return response()->json(['error' => 'Job not found'], 404);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'nullable|string|max:255',
            'salary' => 'nullable|numeric',
            'job_type' => 'required|in:Full-time,Part-time,Contract,Freelancer',
        ]);

        $job->update($validated);

        return response()->json(['message' => 'Job updated successfully', 'job' => $job], 200);
    }
     /**
     * @OA\Delete(
     *     path="/api/jobs/{jobId}",
     *     summary="Delete a job",
     *     description="Delete an existing job listing.",
     *     tags={"Jobs"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="jobId",
     *         in="path",
     *         required=true,
     *         description="Job ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Job deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Job deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Job not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Job not found")
     *         )
     *     )
     * )
     */
    public function destroy($jobId)
    {
        $job = Job::find($jobId);

        if (!$job) {
            return response()->json(['error' => 'Job not found'], 404);
        }

        $job->delete();

        return response()->json(['message' => 'Job deleted successfully'], 200);
    }
     /**
     * @OA\Get(
     *     path="/api/jobs/recommended",
     *     summary="Get recommended jobs based on user skills",
     *     description="Get jobs that match the user's profile skills.",
     *     tags={"Jobs"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="List of recommended jobs",
     *         @OA\JsonContent(
     *             @OA\Property(property="recommended_jobs", type="array", @OA\Items(ref="#/components/schemas/Job"))
     *         )
     *     )
     * )
     */
    public function recommendedJobs()
    {
        $userSkills = auth()->user()->profile->skills;

        if (!$userSkills) {
            return response()->json(['message' => 'Please add skills to see recommendations'], 200);
        }

        $jobs = Job::all();
        $recommendedJobs = $jobs->filter(function ($job) use ($userSkills) {
            foreach ($userSkills as $skill) {
                if (stripos($job->title, $skill) !== false || stripos($job->description, $skill) !== false) {
                    return true;
                }
            }
            return false;
        });

        return response()->json(['recommended_jobs' => $recommendedJobs], 200);
    }
}
