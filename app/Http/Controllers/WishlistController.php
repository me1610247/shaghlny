<?php
namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\Job;
use Illuminate\Support\Facades\Auth;

/**
 * @OA\Tag(
 *     name="Wishlist",
 *     description="Operations related to managing the job wishlist"
 * )
 */

/**
 * @OA\Schema(
 *     schema="WishlistItem",
 *     type="object",
 *     required={"job_id"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="user_id", type="integer", example=2),
 *     @OA\Property(property="job_id", type="integer", example=10),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2024-11-25T12:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2024-11-25T12:00:00Z")
 * )
 */
class WishlistController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/wishlist",
     *     summary="Get all items in the user's wishlist",
     *     description="Retrieve the wishlist items for the authenticated user.",
     *     tags={"Wishlist"},
     *     security={{"sanctum": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Wishlist items retrieved successfully",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/WishlistItem")
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
        $wishlistItems = Auth::user()->wishlists()->with('job')->get();

        return response()->json(['wishlist_items' => $wishlistItems], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/wishlist/{jobId}",
     *     summary="Add a job to the user's wishlist",
     *     description="Add a specified job to the wishlist of the authenticated user.",
     *     tags={"Wishlist"},
     *     security={{"sanctum": {}}},
     *     @OA\Parameter(
     *         name="jobId",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Job added to wishlist",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Job added to wishlist!"),
     *             @OA\Property(property="wishlist_item", ref="#/components/schemas/WishlistItem")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Job not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Job not found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Job already in wishlist",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="This job is already in your wishlist")
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
    public function addToWishlist($jobId)
    {
        $job = Job::find($jobId);

        if (!$job) {
            return response()->json(['error' => 'Job not found'], 404);
        }

        if (Auth::user()->wishlists()->where('job_id', $job->id)->exists()) {
            return response()->json(['error' => 'This job is already in your wishlist'], 400);
        }

        $wishlistItem = Auth::user()->wishlists()->create([
            'job_id' => $job->id,
        ]);

        return response()->json([
            'message' => 'Job added to wishlist!',
            'wishlist_item' => $wishlistItem,
        ], 201);
    }

    /**
     * @OA\Delete(
     *     path="/api/wishlist/{jobId}",
     *     summary="Remove a job from the user's wishlist",
     *     description="Remove a specified job from the wishlist of the authenticated user.",
     *     tags={"Wishlist"},
     *     security={{"sanctum": {}}},
     *     @OA\Parameter(
     *         name="jobId",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Job removed from wishlist",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Job removed from your wishlist!")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Job not found in wishlist",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Job not found in your wishlist")
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
    public function removeFromWishlist($jobId)
    {
        $job = Job::find($jobId);

        if (!$job) {
            return response()->json(['error' => 'Job not found'], 404);
        }

        $deleted = Auth::user()->wishlists()->where('job_id', $job->id)->delete();

        if ($deleted) {
            return response()->json(['message' => 'Job removed from your wishlist!'], 200);
        }

        return response()->json(['error' => 'Job not found in your wishlist'], 404);
    }
}
