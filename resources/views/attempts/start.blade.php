@extends('layouts.app')

@section('content')
<div class="card p-4 mx-auto" style="max-width:750px">
    <h2 class="mb-1">{{ $quiz->title }}</h2>
    <p class="text-muted mb-4">{{ $quiz->description }}</p>

    <form method="POST" action="{{ route('attempts.submit', $quiz) }}" enctype="multipart/form-data">
        @csrf

        <div class="mb-4">
            <label class="form-label fw-bold">Your Name</label>
            <input type="text" name="participant_name" class="form-control" required>
        </div>

        <hr>

        @foreach($quiz->questions as $index => $question)
        <div class="mb-4">
            <p class="fw-bold">Q{{ $index + 1 }}. {!! $question->title !!}
                <span class="text-muted fw-normal">({{ $question->marks }} mark{{ $question->marks > 1 ? 's' : '' }})</span>
            </p>

            @if($question->description)
                <p class="text-muted small">{!! $question->description !!}</p>
            @endif

            @if($question->image_path)
                <img src="{{ Storage::url($question->image_path) }}" class="img-fluid rounded mb-2" style="max-height:200px">
            @endif

            @if($question->video_url)
                <div class="mb-2">
                    <a href="{{ $question->video_url }}" target="_blank" class="btn btn-sm btn-outline-secondary">🎥 Watch Video</a>
                </div>
            @endif

            @if($question->type === 'text')
                <input type="text" name="answers[{{ $question->id }}]" class="form-control">

            @elseif($question->type === 'number')
                <input type="number" name="answers[{{ $question->id }}]" class="form-control">

            @elseif($question->type === 'multiple')
                @foreach($question->options as $option)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox"
                        name="answers[{{ $question->id }}][]" value="{{ $option->id }}">
                    <label class="form-check-label">
                        {{ $option->text }}
                        @if($option->image_path)
                            <img src="{{ Storage::url($option->image_path) }}" height="40" class="ms-2 rounded">
                        @endif
                    </label>
                </div>
                @endforeach

            @else
                @foreach($question->options as $option)
                <div class="form-check">
                    <input class="form-check-input" type="radio"
                        name="answers[{{ $question->id }}]" value="{{ $option->id }}">
                    <label class="form-check-label">
                        {{ $option->text }}
                        @if($option->image_path)
                            <img src="{{ Storage::url($option->image_path) }}" height="40" class="ms-2 rounded">
                        @endif
                    </label>
                </div>
                @endforeach
            @endif
        </div>
        <hr>
        @endforeach

        <button class="btn btn-success w-100 mt-2">Submit Quiz</button>
    </form>
</div>
@endsection