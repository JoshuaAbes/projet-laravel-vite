<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserProgressRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'story_id' => 'required|exists:stories,id',
            'current_chapter_id' => 'required|exists:chapters,id',
        ];
    }
}