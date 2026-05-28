<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function index()
    {
        $quizzes = Quiz::withCount('questions')->latest()->get();
        return view('quizzes.index', compact('quizzes'));
    }

    public function create()
    {
        return view('quizzes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $quiz = Quiz::create($request->only('title', 'description'));

        return redirect()->route('quizzes.show', $quiz)
            ->with('success', 'Quiz created! Now add questions.');
    }

    public function show(Quiz $quiz)
    {
        $quiz->load('questions.options');
        return view('quizzes.show', compact('quiz'));
    }

    public function destroy(Quiz $quiz)
    {
        $quiz->delete();
        return redirect()->route('quizzes.index')
            ->with('success', 'Quiz deleted.');
    }
    public function responses(Quiz $quiz)
{
    $quiz->load('questions');
    $attempts = $quiz->attempts()->latest()->get();
    $totalMarks = $quiz->questions->sum('marks');
    return view('quizzes.responses', compact('quiz', 'attempts', 'totalMarks'));
}
}