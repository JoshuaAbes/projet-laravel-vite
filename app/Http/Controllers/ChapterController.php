<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChapterRequest;
use App\Models\Chapter;
use App\Models\Story;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class ChapterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['show']);
    }

    public function show(Chapter $chapter): JsonResponse
    {
        $story = $chapter->story;
        
        if (!$story->is_published && Auth::id() !== $story->user_id) {
            return response()->json([
                'success' => false,
                'message' => 'Chapter not found',
            ], 404);
        }
        
        $chapter->load('choices:id,chapter_id,text,next_chapter_id');
        
        return response()->json([
            'success' => true,
            'data' => $chapter,
        ]);
    }

    public function store(ChapterRequest $request): JsonResponse
    {
        $story = Story::findOrFail($request->story_id);
        
        if (Auth::id() !== $story->user_id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 403);
        }
        
        $chapter = Chapter::create($request->validated());
        
        return response()->json([
            'success' => true,
            'data' => $chapter,
            'message' => 'Chapter created successfully',
        ], 201);
    }

    public function update(ChapterRequest $request, Chapter $chapter): JsonResponse
    {
        if (Auth::id() !== $chapter->story->user_id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 403);
        }
        
        $chapter->update($request->validated());
        
        return response()->json([
            'success' => true,
            'data' => $chapter,
            'message' => 'Chapter updated successfully',
        ]);
    }

    public function destroy(Chapter $chapter): JsonResponse
    {
        if (Auth::id() !== $chapter->story->user_id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 403);
        }
        
        $chapter->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Chapter deleted successfully',
        ]);
    }
}