<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserProgressRequest;
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
            ->with(['story:id,title', 'currentChapter:id,title'])
            ->get();
            
        return response()->json([
            'success' => true,
            'data' => $progress,
        ]);
    }

    public function show(int $storyId): JsonResponse
    {
        $progress = UserProgress::where('user_id', Auth::id())
            ->where('story_id', $storyId)
            ->with('currentChapter')
            ->first();
            
        if (!$progress) {
            return response()->json([
                'success' => false,
                'message' => 'No progress found for this story',
            ], 404);
        }
        
        return response()->json([
            'success' => true,
            'data' => $progress,
        ]);
    }

    public function store(UserProgressRequest $request): JsonResponse
    {
        $progress = UserProgress::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'story_id' => $request->story_id,
            ],
            [
                'current_chapter_id' => $request->current_chapter_id,
            ]
        );
        
        return response()->json([
            'success' => true,
            'data' => $progress,
            'message' => 'Progress saved successfully',
        ]);
    }
}