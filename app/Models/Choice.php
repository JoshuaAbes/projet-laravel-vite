<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Choice extends Model
{
    use HasFactory;

    protected $fillable = [
        'chapter_id',
        'text',
        'next_chapter_id',
    ];

    public function chapter(): BelongsTo
    {
        return $this->belongsTo(Chapter::class);
    }

    public function nextChapter(): BelongsTo
    {
        return $this->belongsTo(Chapter::class, 'next_chapter_id');
    }
}
