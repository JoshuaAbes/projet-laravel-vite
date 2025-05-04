<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\ChapterController;
use App\Http\Controllers\Api\V1\ChoiceController;
use App\Http\Controllers\Api\V1\StoryController;
use App\Http\Controllers\Api\V1\UserProgressController;

Route::get('/', function () {
  return view('test');
});

// Instead of using Sanctum (or something similar) for API authentication,
// we are using the built-in Laravel session authentication system.
require_once __DIR__ . '/api.php';

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// API Version 1 Group
Route::prefix('v1')->group(function () {
    // Stories routes
    Route::apiResource('stories', StoryController::class);
    
    // Chapters routes
    Route::apiResource('chapters', ChapterController::class)->except(['index']);
    
    // Choices routes
    Route::apiResource('choices', ChoiceController::class)->except(['index', 'show']);
    
    // User progress routes
    Route::get('progress', [UserProgressController::class, 'index']);
    Route::get('progress/{storyId}', [UserProgressController::class, 'show']);
    Route::post('progress', [UserProgressController::class, 'store']);
});