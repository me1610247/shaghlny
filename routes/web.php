<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WishlistController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('authenticate');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Registration Routes
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'processRegister'])->name('processRegister');

// Home
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Profile 
Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

// Post Job
Route::get('jobs/create', [JobController::class, 'create'])->name('jobs.create');
Route::post('jobs', [JobController::class, 'store'])->name('jobs.store');
Route::get('my-jobs', [JobController::class, 'myjobs'])->name('jobs.mine');
Route::get('jobs-index', [JobController::class, 'index'])->name('jobs.index');
Route::get('jobs/{job}/edit', [JobController::class, 'edit'])->name('jobs.edit');
Route::put('jobs/{job}', [JobController::class, 'update'])->name('jobs.update');
Route::delete('jobs/{job}', [JobController::class, 'destroy'])->name('jobs.destroy');
Route::get('/jobs/recommendations', [JobController::class, 'recommendedJobs'])->name('jobs.recommendations');

// Wishlisht
Route::post('/wishlist/{jobId}/add', [WishlistController::class, 'addToWishlist'])->name('wishlist.add');
Route::post('/wishlist/{jobId}/remove', [WishlistController::class, 'removeFromWishlist'])->name('wishlist.remove');
Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');

// Apply 
Route::post('/jobs/{jobId}/apply', [JobController::class, 'apply'])->name('jobs.apply');
Route::get('/applied-jobs', [JobController::class, 'appliedJobs'])->name('jobs.applied');
Route::get('/jobs/{job}/applicants', [JobController::class, 'showApplicants'])->name('jobs.applicants');

// Company
Route::get('/jobs/create-as-company', [JobController::class, 'createAsCompany'])->name('jobs.create.as.company');
Route::post('/jobs/store-as-company', [JobController::class, 'storeAsCompany'])->name('jobs.store.as.company');
Route::get('/jobs/{job}/questions', [JobController::class, 'createQuestions'])->name('jobs.questions.create');
Route::post('/jobs/{job}/questions', [JobController::class, 'storeQuestions'])->name('jobs.questions.store');
Route::get('/companies', [JobController::class, 'CompanyIndex'])->name('companies.index');
