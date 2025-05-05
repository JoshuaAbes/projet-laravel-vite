<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Obtenir les informations de l'utilisateur authentifié
     */
    public function user(Request $request)
    {
        if (Auth::check()) {
            return $this->successResponse(Auth::user());
        }
        
        return $this->errorResponse('Non authentifié', 401);
    }
}