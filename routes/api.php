<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Api\V1\ChapterController;
use App\Http\Controllers\Api\V1\ChoiceController;
use App\Http\Controllers\Api\V1\StoryController;
use App\Http\Controllers\Api\V1\UserProgressController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('api/v1/')->group(function () {
  Route::get('/test', function () {
    return response()->json(['message' => 'Hello, World from api!']);
  });

  Route::delete('/test', function () {
    return response()->json(['message' => 'Deleting']);
  });

  Route::post('/time', function () {
    $timeClient = request()->input('timeClient', 0);
    sleep(2); // Simulate a long-running process
    return response()->json(['timeClient' => $timeClient, 'timeServer' => now()]);
  });

  Route::get('/user', [AuthController::class, 'user']);

  Route::middleware('auth:sanctum')->group(function () {
    // Routes qui nécessitent une authentification
    Route::post('stories', [StoryController::class, 'store']);
    Route::put('stories/{story}', [StoryController::class, 'update']);
    Route::delete('stories/{story}', [StoryController::class, 'destroy']);
    
    Route::post('chapters', [ChapterController::class, 'store']);
    Route::put('chapters/{chapter}', [ChapterController::class, 'update']);
    Route::delete('chapters/{chapter}', [ChapterController::class, 'destroy']);
    
    Route::apiResource('choices', ChoiceController::class)->except(['index', 'show']);
    
    // Routes pour la progression utilisateur
    Route::apiResource('progress', UserProgressController::class);
  });

  // Routes publiques
  Route::get('stories', [StoryController::class, 'index']);
  Route::get('stories/{story}', [StoryController::class, 'show']);
  Route::get('chapters/{chapter}', [ChapterController::class, 'show']);
});