@extends('layouts.app')

@section('content')
<div class="card p-4 mx-auto text-center" style="max-width:600px">
    <h2 class="mb-1">🎉 Quiz Completed!</h2>
    <p class="text-muted">{{ $attempt->quiz->title }}</p>

    <div class="display-4 fw-bold text-primary my-3">
        {{ $attempt->total_score }}
        <span class="fs-5 text-muted">/ {{ $attempt->quiz->questions->sum('marks') }}</span>
    </div>

    <p class="mb-4">Well done, <strong>{{ $attempt->participant_name }}</strong>!</p>

    <hr>

    @foreach($attempt->answers as $answer)
    <div class="text-start mb-3">
        <p class="fw-bold mb-1">{{ $answer->question->title }}</p>
        <p class="mb-0 text-muted small">
            Your answer:
            @if($answer->values->isNotEmpty())
                @foreach($answer->values as $val)
                    {{ $val->option?->text ?? $val->text_value }}
                @endforeach
            @else
                <em>No answer</em>
            @endif
        </p>
    </div>
    <hr>
    @endforeach

    <a href="{{ route('quizzes.index') }}" class="btn btn-primary">Back to Quizzes</a>
    <a href="{{ route('attempts.start', $attempt->quiz) }}" class="btn btn-outline-primary ms-2">Try Again</a>
</div>
@endsection