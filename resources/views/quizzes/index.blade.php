@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>All Quizzes</h2>
    <a href="{{ route('quizzes.create') }}" class="btn btn-primary">+ Create Quiz</a>
</div>

@forelse($quizzes as $quiz)
<div class="card mb-3 p-3">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h5 class="mb-1">{{ $quiz->title }}</h5>
            <small class="text-muted">{{ $quiz->questions_count }} questions</small>
            <p class="mb-0 mt-1">{{ $quiz->description }}</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('quizzes.show', $quiz) }}" class="btn btn-outline-primary btn-sm">Manage</a>
            <a href="{{ route('attempts.start', $quiz) }}" class="btn btn-success btn-sm">Attempt</a>
            <form method="POST" action="{{ route('quizzes.destroy', $quiz) }}" onsubmit="return confirm('Delete this quiz?')">
                @csrf @method('DELETE')
                <button class="btn btn-outline-danger btn-sm">Delete</button>
            </form>
        </div>
    </div>
</div>
@empty
<div class="text-center py-5 text-muted">
    <h4>No quizzes yet.</h4>
    <a href="{{ route('quizzes.create') }}" class="btn btn-primary mt-2">Create your first quiz</a>
</div>
@endforelse
@endsection
