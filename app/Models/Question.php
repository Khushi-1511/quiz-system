<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Question extends Model
{
    protected $fillable = [
        'quiz_id', 'type', 'title', 'description',
        'image_path', 'video_url', 'marks', 'order'
    ];

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    public function options(): HasMany
    {
        return $this->hasMany(Option::class)->orderBy('order');
    }

    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }

    public function needsOptions(): bool
    {
        return in_array($this->type, ['binary', 'single', 'multiple']);
    }

    public function isTextBased(): bool
    {
        return in_array($this->type, ['text', 'number']);
    }
}