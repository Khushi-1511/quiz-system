<?php

namespace App\Services\Evaluators;

use App\Models\Answer;
use App\Models\Question;

interface QuestionEvaluator
{
    public function evaluate(Question $question, Answer $answer): int;
}