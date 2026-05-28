@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2>{{ $quiz->title }}</h2>
        <p class="text-muted mb-0">All responses — {{ $attempts->count() }} attempt(s)</p>
    </div>
    <a href="{{ route('quizzes.show', $quiz) }}" class="btn btn-outline-primary">← Back to Quiz</a>
</div>

@if($attempts->isEmpty())
    <div class="text-center text-muted py-5">
        <h5>No attempts yet.</h5>
    </div>
@else
<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Participant</th>
                    <th>Score</th>
                    <th>Percentage</th>
                    <th>Submitted At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($attempts as $i => $attempt)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td><strong>{{ $attempt->participant_name }}</strong></td>
                    <td>{{ $attempt->total_score }} / {{ $totalMarks }}</td>
                    <td>
                        @php $pct = $totalMarks > 0 ? round(($attempt->total_score / $totalMarks) * 100) : 0; @endphp
                        <div class="progress" style="height:20px;min-width:100px">
                            <div class="progress-bar {{ $pct >= 50 ? 'bg-success' : 'bg-danger' }}"
                                style="width:{{ $pct }}%">{{ $pct }}%</div>
                        </div>
                    </td>
                    <td>{{ $attempt->submitted_at?->format('d M Y, h:i A') ?? 'N/A' }}</td>
                    <td>
                        <a href="{{ route('attempts.result', $attempt) }}"
                            class="btn btn-sm btn-outline-primary">View Details</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif
@endsection
