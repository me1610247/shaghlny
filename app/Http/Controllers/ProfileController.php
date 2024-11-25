<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;

/**
 * @OA\Tag(
 *     name="Profile",
 *     description="Operations related to the user profile"
 * )
 */
/**
 * @OA\Schema(
 *     schema="Profile",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="user_id", type="integer", example=1),
 *     @OA\Property(property="phone", type="string", example="1234567890"),
 *     @OA\Property(property="date_of_birth", type="string", format="date", example="1990-01-01"),
 *     @OA\Property(property="skills", type="array", @OA\Items(type="string"), example={"Laravel", "PHP"})
 * )
 */
class ProfileController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/profile",
     *     summary="Get the authenticated user's profile",
     *     description="Retrieve the profile of the currently authenticated user.",
     *     tags={"Profile"},
     *     security={{"sanctum": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Profile retrieved successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(ref="#/components/schemas/Profile")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Profile not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Profile not found")
     *         )
     *     )
     * )
     */
    public function show()
    {
        $profile = Profile::where('user_id', Auth::id())->first();

        if (!$profile) {
            return response()->json(['error' => 'Profile not found'], 404);
        }

        return response()->json(['profile' => $profile], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/profile/edit",
     *     summary="Edit the authenticated user's profile",
     *     description="Ensure a profile exists for the authenticated user and retrieve it for editing.",
     *     tags={"Profile"},
     *     security={{"sanctum": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Profile retrieved for editing",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(ref="#/components/schemas/Profile")
     *         )
     *     )
     * )
     */
    public function edit()
    {
        $profile = Profile::firstOrCreate(
            ['user_id' => Auth::id()],
            ['skills' => []]
        );

        return response()->json(['profile' => $profile], 200);
    }

    /**
     * @OA\Put(
     *     path="/api/profile",
     *     summary="Update the authenticated user's profile",
     *     description="Update the profile of the authenticated user with the provided data.",
     *     tags={"Profile"},
     *     security={{"sanctum": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="phone", type="string", example="1234567890"),
     *             @OA\Property(property="date_of_birth", type="string", format="date", example="1990-01-01"),
     *             @OA\Property(property="skills", type="array", @OA\Items(type="string"), example={"Laravel", "PHP"})
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Profile updated successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Profile updated successfully"),
     *             @OA\Property(ref="#/components/schemas/Profile")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="errors", type="object")
     *         )
     *     )
     * )
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'phone' => 'nullable|string|max:15',
            'date_of_birth' => 'nullable|date',
            'skills' => 'nullable|array',
        ]);

        $profile = Profile::updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'phone' => $validated['phone'],
                'date_of_birth' => $validated['date_of_birth'],
                'skills' => $validated['skills'],
            ]
        );

        return response()->json([
            'message' => 'Profile updated successfully',
            'profile' => $profile,
        ], 200);
    }
}
