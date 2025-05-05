<?php

namespace App\Http\Traits;

trait ApiResponse
{
    /**
     * Renvoyer une réponse de succès
     */
    protected function successResponse($data, string $message = null, int $code = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ], $code);
    }

    /**
     * Renvoyer une réponse d'erreur
     */
    protected function errorResponse(string $message, int $code)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data' => null
        ], $code);
    }
}