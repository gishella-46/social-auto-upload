<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SocialAccountController;
use App\Http\Controllers\SchedulerController;

// =============================
// Auth Routes
// =============================
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/profile', [AuthController::class, 'profile']);

    // =============================
    // Post CRUD
    // =============================
    Route::get('/posts', [PostController::class, 'index']);          // list semua post user
    Route::get('/posts/{id}', [PostController::class, 'show']);      // lihat detail post
    Route::post('/posts', [PostController::class, 'store']);         // buat post baru
    Route::put('/posts/{id}', [PostController::class, 'update']);    // update post
    Route::delete('/posts/{id}', [PostController::class, 'destroy']); // hapus post

    // =============================
    // Social Accounts
    // =============================
    Route::get('/social-accounts', [SocialAccountController::class, 'index']);   // list akun sosial
    Route::post('/social-accounts/connect', [SocialAccountController::class, 'connect']); // hubungkan akun sosial media
    Route::delete('/social-accounts/{id}', [SocialAccountController::class, 'destroy']);  // hapus koneksi akun sosial media

    // =============================
    // Scheduler (AI Worker)
    // =============================
    Route::get('/scheduler/queue', [SchedulerController::class, 'getScheduledPosts']); // ambil daftar post terjadwal untuk AI Worker

    // =============================
    // Webhook / Callback dari AI Worker
    // =============================
    Route::post('/webhook/post-status', [SchedulerController::class, 'updatePostStatus']); // update status post setelah AI worker upload
});
