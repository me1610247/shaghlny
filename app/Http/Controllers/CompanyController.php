<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\JobQuestion;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Company",
 *     description="Operations related to managing company job positions"
 * )
 */

class CompanyController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/company/position/create",
     *     summary="Create a new job position",
     *     description="Returns a message instructing the user on how to submit a job position.",
     *     tags={"Company"},
     *     security={{"sanctum": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Position creation instructions",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Use this endpoint to submit position details.")
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
    public function createPosition()
    {
        return response()->json(['message' => 'Use this endpoint to submit position details.'], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/company/position",
     *     summary="Store a new job position with associated questions",
     *     description="Store a new job position with a title, description, location, and optional questions.",
     *     tags={"Company"},
     *     security={{"sanctum": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="title", type="string", example="Software Engineer"),
     *             @OA\Property(property="description", type="string", example="Develop and maintain software."),
     *             @OA\Property(property="location", type="string", example="New York, NY"),
     *             @OA\Property(property="questions", type="array", @OA\Items(type="string"), example={"What is your experience with PHP?", "How do you handle deadlines?"})
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Job position and questions created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Position and questions added successfully!"),
     *             @OA\Property(property="job", type="object", ref="#/components/schemas/Job")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="errors", type="object")
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
    public function storePosition(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'questions' => 'array',
            'questions.*' => 'required|string|max:255',
        ]);

        $job = Job::create([
            'company_id' => auth()->user()->company->id, // Assuming a company relationship exists
            'title' => $validated['title'],
            'description' => $validated['description'],
            'location' => $validated['location'],
        ]);

        // Save associated questions
        if (!empty($validated['questions'])) {
            foreach ($validated['questions'] as $question) {
                JobQuestion::create([
                    'job_id' => $job->id,
                    'question' => $question,
                ]);
            }
        }

        return response()->json([
            'message' => 'Position and questions added successfully!',
            'job' => $job,
        ], 201);
    }
}
