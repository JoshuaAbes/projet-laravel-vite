<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Chapter extends Model
{
    use HasFactory;

    protected $fillable = [
        'story_id',
        'title',
        'content',
        'is_ending',
    ];

    public function story(): BelongsTo
    {
        return $this->belongsTo(Story::class);
    }

    public function choices(): HasMany
    {
        return $this->hasMany(Choice::class);
    }

    public function choicesLeadingHere(): HasMany
    {
        return $this->hasMany(Choice::class, 'next_chapter_id');
    }
}
