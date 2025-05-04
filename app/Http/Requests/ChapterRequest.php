<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChapterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'story_id' => 'required|exists:stories,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'is_ending' => 'boolean',
        ];
    }
}
