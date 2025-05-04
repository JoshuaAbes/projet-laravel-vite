<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChoiceRequest;
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
        $chapter = $request->chapter_id;
        
        if (Auth::id() !== $chapter->story->user_id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 403);
        }
        
        $choice = Choice::create($request->validated());
        
        return response()->json([
            'success' => true,
            'data' => $choice,
            'message' => 'Choice created successfully',
        ], 201);
    }

    public function update(ChoiceRequest $request, Choice $choice): JsonResponse
    {
        if (Auth::id() !== $choice->chapter->story->user_id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 403);
        }
        
        $choice->update($request->validated());
        
        return response()->json([
            'success' => true,
            'data' => $choice,
            'message' => 'Choice updated successfully',
        ]);
    }

    public function destroy(Choice $choice): JsonResponse
    {
        if (Auth::id() !== $choice->chapter->story->user_id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 403);
        }
        
        $choice->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Choice deleted successfully',
        ]);
    }
}