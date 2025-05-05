<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserProgressRequest;
use App\Models\Story;
use App\Models\UserProgress;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class UserProgressController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index(): JsonResponse
    {
        $progress = UserProgress::where('user_id', Auth::id())
            ->with('story:id,title')
            ->get();
            
        return $this->successResponse($progress);
    }

    public function show(int $storyId): JsonResponse
    {
        $progress = UserProgress::where('user_id', Auth::id())
            ->where('story_id', $storyId)
            ->first();
            
        if (!$progress) {
            return $this->errorResponse('No progress found for this story', 404);
        }
        
        return $this->successResponse($progress);
    }

    public function store(UserProgressRequest $request): JsonResponse
    {
        $progress = UserProgress::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'story_id' => $request->story_id
            ],
            [
                'current_chapter_id' => $request->chapter_id
            ]
        );
        
        return $this->successResponse($progress, 'Progress saved successfully');
    }
}