<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function create(Quiz $quiz)
    {
        return view('questions.create', compact('quiz'));
    }

    public function store(Request $request, Quiz $quiz)
    {
        $request->validate([
            'type'        => 'required|in:binary,single,multiple,number,text',
            'title'       => 'required|string',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|max:2048',
            'video_url'   => 'nullable|url',
            'marks'       => 'required|integer|min:1',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('questions', 'public');
        }

        $question = $quiz->questions()->create([
            'type'        => $request->type,
            'title'       => $request->title,
            'description' => $request->description,
            'image_path'  => $imagePath,
            'video_url'   => $request->video_url,
            'marks'       => $request->marks,
            'order'       => $quiz->questions()->count(),
        ]);

        if (in_array($request->type, ['binary', 'single', 'multiple'])) {
            $this->saveOptions($request, $question);
        } elseif (in_array($request->type, ['text', 'number'])) {
            $question->options()->create([
                'text'       => $request->correct_answer,
                'is_correct' => true,
            ]);
        }

        return redirect()->route('quizzes.show', $quiz)
            ->with('success', 'Question added!');
    }

    private function saveOptions(Request $request, Question $question): void
    {
        $texts   = $request->input('options', []);
        $correct = array_map('strval', (array) $request->input('is_correct', []));
        $images  = $request->file('option_images', []);

        foreach ($texts as $index => $text) {
            $imagePath = null;
            if (!empty($images[$index])) {
                $imagePath = $images[$index]->store('options', 'public');
            }

            $isCorrect = in_array((string)$index, $correct);

            \Log::info("Option $index '$text' is_correct: " . ($isCorrect ? 'YES' : 'NO'));

            $question->options()->create([
                'text'       => $text,
                'image_path' => $imagePath,
                'is_correct' => $isCorrect,
                'order'      => $index,
            ]);
        }
    }

    public function destroy(Quiz $quiz, Question $question)
    {
        $question->delete();
        return redirect()->route('quizzes.show', $quiz)
            ->with('success', 'Question deleted.');
    }
}