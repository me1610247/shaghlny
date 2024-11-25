<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobApplication;
use App\Models\Job;

class JobApplicationController extends Controller
{
    public function showApplications($jobId)
    {
        $job = Job::find($jobId);

        // Check if job exists
        if (!$job) {
            return response()->json(['error' => 'Job not found'], 404);
        }

        // Ensure the authenticated user owns the job
        if ($job->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized to view applications for this job'], 403);
        }

        // Fetch job applications
        $applications = JobApplication::where('job_id', $jobId)->get();

        return response()->json([
            'job' => $job,
            'applications' => $applications,
        ], 200);
    }
}
