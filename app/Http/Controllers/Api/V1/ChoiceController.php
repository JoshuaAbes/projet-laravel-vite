<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChoiceRequest;
use App\Models\Chapter;
use App\Models\Choice;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class ChoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function store(ChoiceRequest $request): JsonResponse
    {
        $chapter = Chapter::findOrFail($request->chapter_id);
        
        if (Auth::id() !== $chapter->story->user_id) {
            return $this->errorResponse('Unauthorized', 403);
        }
        
        $choice = new Choice($request->validated());
        $choice->save();
        
        return $this->successResponse($choice, 'Choice created successfully', 201);
    }

    public function update(ChoiceRequest $request, Choice $choice): JsonResponse
    {
        if (Auth::id() !== $choice->chapter->story->user_id) {
            return $this->errorResponse('Unauthorized', 403);
        }
        
        $choice->update($request->validated());
        
        return $this->successResponse($choice, 'Choice updated successfully');
    }

    public function destroy(Choice $choice): JsonResponse
    {
        if (Auth::id() !== $choice->chapter->story->user_id) {
            return $this->errorResponse('Unauthorized', 403);
        }
        
        $choice->delete();
        
        return $this->successResponse(null, 'Choice deleted successfully');
    }
}