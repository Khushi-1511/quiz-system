<?php

namespace App\Services\Evaluators;

use App\Models\Answer;
use App\Models\Question;

class TextEvaluator implements QuestionEvaluator
{
    public function evaluate(Question $question, Answer $answer): int
    {
        $given = strtolower(trim($answer->values->first()?->text_value ?? ''));
        $correct = strtolower(trim($question->options->first()?->text ?? ''));

        return $given === $correct ? $question->marks : 0;
    }
}