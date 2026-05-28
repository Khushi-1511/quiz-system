<?php

namespace App\Services\Evaluators;

use App\Models\Answer;
use App\Models\Question;

class BinaryEvaluator implements QuestionEvaluator
{
    public function evaluate(Question $question, Answer $answer): int
    {
        $selectedOptionId = $answer->values->first()?->option_id;
        $correct = $question->options->firstWhere('is_correct', true);

        return $correct && $selectedOptionId == $correct->id ? $question->marks : 0;
    }
}