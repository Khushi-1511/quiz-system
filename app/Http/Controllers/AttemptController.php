<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Attempt;
use App\Models\Answer;
use App\Models\AnswerValue;
use App\Services\QuizEvaluationService;
use Illuminate\Http\Request;

class AttemptController extends Controller
{
    public function start(Quiz $quiz)
    {
        $quiz->load('questions.options');
        return view('attempts.start', compact('quiz'));
    }

    public function submit(Request $request, Quiz $quiz)
    {
        $request->validate([
            'participant_name' => 'required|string|max:255',
        ]);

        $attempt = Attempt::create([
            'quiz_id'          => $quiz->id,
            'participant_name' => $request->participant_name,
        ]);

        $quiz->load('questions.options');

        foreach ($quiz->questions as $question) {
            $answer = Answer::create([
                'attempt_id'  => $attempt->id,
                'question_id' => $question->id,
            ]);

            $this->saveAnswerValues($request, $answer, $question);
        }

        $score = (new QuizEvaluationService())->evaluate($attempt);

        return redirect()->route('attempts.result', $attempt);
    }

    private function saveAnswerValues(Request $request, Answer $answer, $question): void
    {
        $key = 'answers.' . $question->id;

        if (in_array($question->type, ['text', 'number'])) {
            AnswerValue::create([
                'answer_id'  => $answer->id,
                'text_value' => $request->input($key),
            ]);
        } elseif ($question->type === 'multiple') {
            foreach ((array) $request->input($key, []) as $optionId) {
                AnswerValue::create([
                    'answer_id' => $answer->id,
                    'option_id' => $optionId,
                ]);
            }
        } else {
            // binary or single
            AnswerValue::create([
                'answer_id' => $answer->id,
                'option_id' => $request->input($key),
            ]);
        }
    }

    public function result(Attempt $attempt)
    {
        $attempt->load('quiz.questions.options', 'answers.values.option', 'answers.question');
        return view('attempts.result', compact('attempt'));
    }
}