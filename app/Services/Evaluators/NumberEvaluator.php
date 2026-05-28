<?php

namespace App\Services\Evaluators;

use App\Models\Answer;
use App\Models\Question;

class NumberEvaluator implements QuestionEvaluator
{
    public function evaluate(Question $question, Answer $answer): int
    {
        $given = trim($answer->values->first()?->text_value ?? '');
        $correct = trim($question->options->first()?->text ?? '');

        return $given === $correct ? $question->marks : 0;
    }
}