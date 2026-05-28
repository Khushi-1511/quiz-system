<?php

namespace App\Services\Evaluators;

use App\Models\Answer;
use App\Models\Question;

class MultipleChoiceEvaluator implements QuestionEvaluator
{
    public function evaluate(Question $question, Answer $answer): int
    {
        $selectedIds = $answer->values->pluck('option_id')->sort()->values()->toArray();
        $correctIds = $question->options->where('is_correct', true)->pluck('id')->sort()->values()->toArray();

        return $selectedIds === $correctIds ? $question->marks : 0;
    }
}