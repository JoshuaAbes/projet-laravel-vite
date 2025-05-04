<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserProgress extends Model
{
    use HasFactory;
    
    protected $table = 'user_progress';

    protected $fillable = [
        'user_id',
        'story_id',
        'current_chapter_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function story(): BelongsTo
    {
        return $this->belongsTo(Story::class);
    }

    public function currentChapter(): BelongsTo
    {
        return $this->belongsTo(Chapter::class, 'current_chapter_id');
    }
}
