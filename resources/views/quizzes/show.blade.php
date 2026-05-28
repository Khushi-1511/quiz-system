@php use Illuminate\Support\Facades\Storage; @endphp
@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h2>{{ $quiz->title }}</h2>
        <p class="text-muted">{{ $quiz->description }}</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('questions.create', $quiz) }}" class="btn btn-primary">+ Add Question</a>
        <a href="{{ route('quizzes.responses', $quiz) }}" class="btn btn-outline-secondary">📊 Responses</a>
        <a href="{{ route('attempts.start', $quiz) }}" class="btn btn-success">Attempt Quiz</a>
    </div>
</div>

@forelse($quiz->questions as $question)
<div class="card mb-3 p-3">
    <div class="d-flex justify-content-between">
        <div>
            <span class="badge bg-secondary me-2">{{ strtoupper($question->type) }}</span>
            <span class="fw-bold">{{ $question->title }}</span>
            <span class="text-muted ms-2">({{ $question->marks }} mark{{ $question->marks > 1 ? 's' : '' }})</span>

            @if($question->image_path)
                <div class="mt-2">
                    <img src="{{ Storage::url($question->image_path) }}" height="80" class="rounded">
                </div>
            @endif

            @if($question->video_url)
                <div class="mt-1">
                    <a href="{{ $question->video_url }}" target="_blank" class="text-primary small">🎥 Video</a>
                </div>
            @endif

            @if($question->options->count())
                <ul class="mt-2 mb-0">
                    @foreach($question->options as $option)
                        <li class="{{ $option->is_correct ? 'text-success fw-bold' : '' }}">
                            {{ $option->text }} {{ $option->is_correct ? '✓' : '' }}
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
        <form method="POST" action="{{ route('questions.destroy', [$quiz, $question]) }}"
            onsubmit="return confirm('Delete?')">
            @csrf @method('DELETE')
            <button class="btn btn-outline-danger btn-sm">Delete</button>
        </form>
    </div>
</div>
@empty
    <div class="text-center text-muted py-4">No questions yet. Add your first question!</div>
@endforelse
@endsection