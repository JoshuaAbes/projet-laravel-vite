<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoryRequest;
use App\Models\Story;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class StoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['index', 'show']);
    }

    public function index(): JsonResponse
    {
        $stories = Story::where('is_published', true)
            ->with('chapters:id,story_id,title')
            ->get();
            
        return response()->json([
            'success' => true,
            'data' => $stories,
        ]);
    }

    public function show(Story $story): JsonResponse
    {
        if (!$story->is_published && Auth::id() !== $story->user_id) {
            return response()->json([
                'success' => false,
                'message' => 'Story not found',
            ], 404);
        }
        
        $story->load([
            'chapters:id,story_id,title,is_ending',
        ]);
        
        return response()->json([
            'success' => true,
            'data' => $story,
        ]);
    }

    public function store(StoryRequest $request): JsonResponse
    {
        $story = new Story($request->validated());
        $story->user_id = Auth::id();
        $story->save();
        
        return response()->json([
            'success' => true,
            'data' => $story,
            'message' => 'Story created successfully',
        ], 201);
    }

    public function update(StoryRequest $request, Story $story): JsonResponse
    {
        if (Auth::id() !== $story->user_id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 403);
        }
        
        $story->update($request->validated());
        
        return response()->json([
            'success' => true,
            'data' => $story,
            'message' => 'Story updated successfully',
        ]);
    }

    public function destroy(Story $story): JsonResponse
    {
        if (Auth::id() !== $story->user_id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 403);
        }
        
        $story->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Story deleted successfully',
        ]);
    }
}