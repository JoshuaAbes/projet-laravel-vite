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
        $chapter->load('choices:id,chapter_id,text,next_chapter_id');
        return $this->successResponse($chapter);
    }

    public function store(ChapterRequest $request): JsonResponse
    {
        $story = Story::findOrFail($request->story_id);
        
        if (Auth::id() !== $story->user_id) {
            return $this->errorResponse('Unauthorized', 403);
        }
        
        $chapter = new Chapter($request->validated());
        $chapter->save();
        
        return $this->successResponse($chapter, 'Chapter created successfully', 201);
    }

    public function update(ChapterRequest $request, Chapter $chapter): JsonResponse
    {
        if (Auth::id() !== $chapter->story->user_id) {
            return $this->errorResponse('Unauthorized', 403);
        }
        
        $chapter->update($request->validated());
        
        return $this->successResponse($chapter, 'Chapter updated successfully');
    }

    public function destroy(Chapter $chapter): JsonResponse
    {
        if (Auth::id() !== $chapter->story->user_id) {
            return $this->errorResponse('Unauthorized', 403);
        }
        
        $chapter->delete();
        
        return $this->successResponse(null, 'Chapter deleted successfully');
    }
}