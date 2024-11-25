<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\JobApplicationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Public routes (if needed)
Route::get('/home', [HomeController::class, 'index']);
Route::middleware('auth:sanctum')->delete('/delete-account', [AuthController::class, 'deleteAccount']);

// Protected routes (require authentication)
Route::middleware('auth:sanctum')->group(function () {
    // Job Routes
    Route::prefix('jobs')->group(function () {
        Route::get('/', [JobController::class, 'index']); // List all jobs
        Route::get('/{id}', [JobController::class, 'show']); // Get job details
        Route::post('/', [JobController::class, 'store']); // Create a new job
        Route::put('/{id}', [JobController::class, 'update']); // Update a job
        Route::delete('/{id}', [JobController::class, 'destroy']); // Delete a job
        Route::get('/my-jobs', [JobController::class, 'myJobs']); // View user's jobs
        Route::get('/recommended', [JobController::class, 'recommendedJobs']); // View recommended jobs
        Route::post('/apply/{id}', [JobController::class, 'apply']); // Apply to a job
        Route::get('/applications/{id}', [JobController::class, 'showApplicants']); // View job applicants
    });

    // Profile Routes
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'show']); // View user profile
        Route::put('/', [ProfileController::class, 'update']); // Update user profile
    });

    // Wishlist Routes
    Route::prefix('wishlist')->group(function () {
        Route::get('/', [WishlistController::class, 'index']); // View wishlist
        Route::post('/add/{jobId}', [WishlistController::class, 'addToWishlist']); // Add a job to wishlist
        Route::delete('/remove/{jobId}', [WishlistController::class, 'removeFromWishlist']); // Remove a job from wishlist
    });

    // Company Routes
    Route::prefix('company')->group(function () {
        Route::post('/positions', [CompanyController::class, 'storePosition']); // Create a new position with questions
        Route::get('/positions/create', [CompanyController::class, 'createPosition']); // Informational endpoint
    });

    // Job Application Routes
    Route::prefix('applications')->group(function () {
        Route::get('/{jobId}', [JobApplicationController::class, 'showApplications']); // View job applications
    });
});
