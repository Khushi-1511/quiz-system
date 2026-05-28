@extends('layouts.app')

@section('content')
<div class="card p-4 mx-auto" style="max-width:600px">
    <h3 class="mb-4">Create New Quiz</h3>
    <form method="POST" action="{{ route('quizzes.store') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label fw-bold">Title</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold">Description</label>
            <textarea name="description" class="form-control" rows="3"></textarea>
        </div>
        <button class="btn btn-primary w-100">Create Quiz</button>
    </form>
</div>
@endsection
