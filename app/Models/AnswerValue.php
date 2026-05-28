<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnswerValue extends Model
{
    protected $fillable = ['answer_id', 'option_id', 'text_value'];

    public function answer(): BelongsTo
    {
        return $this->belongsTo(Answer::class);
    }

    public function option(): BelongsTo
    {
        return $this->belongsTo(Option::class);
    }
}