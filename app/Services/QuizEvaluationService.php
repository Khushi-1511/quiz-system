<?php

namespace App\Services;

use App\Models\Attempt;
use App\Models\Question;
use App\Services\Evaluators\BinaryEvaluator;
use App\Services\Evaluators\SingleChoiceEvaluator;
use App\Services\Evaluators\MultipleChoiceEvaluator;
use App\Services\Evaluators\NumberEvaluator;
use App\Services\Evaluators\TextEvaluator;
use App\Services\Evaluators\QuestionEvaluator;

class QuizEvaluationService
{
    // To add a new question type in future, just add one line here!
    private array $evaluators = [
        'binary'   => BinaryEvaluator::class,
        'single'   => SingleChoiceEvaluator::class,
        'multiple' => MultipleChoiceEvaluator::class,
        'number'   => NumberEvaluator::class,
        'text'     => TextEvaluator::class,
    ];

    public function evaluate(Attempt $attempt): int
    {
        $attempt->load('answers.values', 'answers.question.options');

        $totalScore = 0;

        foreach ($attempt->answers as $answer) {
            $question = $answer->question;
            $evaluator = $this->resolveEvaluator($question->type);
            $totalScore += $evaluator->evaluate($question, $answer);
        }

        $attempt->update([
            'total_score' => $totalScore,
            'submitted_at' => now(),
        ]);

        return $totalScore;
    }

    private function resolveEvaluator(string $type): QuestionEvaluator
    {
        $class = $this->evaluators[$type] ?? TextEvaluator::class;
        return new $class();
    }
}