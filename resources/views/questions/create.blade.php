@extends('layouts.app')

@section('content')
<div class="card p-4 mx-auto" style="max-width:700px">
    <h3 class="mb-4">Add Question to: {{ $quiz->title }}</h3>

    <form method="POST" action="{{ route('questions.store', $quiz) }}" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label class="form-label fw-bold">Question Type</label>
            <select name="type" id="type" class="form-select" required>
                <option value="">-- Select Type --</option>
                <option value="binary">Binary (Yes/No or True/False)</option>
                <option value="single">Single Choice</option>
                <option value="multiple">Multiple Choice</option>
                <option value="number">Number Input</option>
                <option value="text">Text Input</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Question Title</label>
            <textarea name="title" class="form-control" rows="2" required></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Description (optional, HTML supported)</label>
            <textarea name="description" class="form-control" rows="2"></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Image (optional)</label>
            <input type="file" name="image" class="form-control" accept="image/*">
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Video URL (optional)</label>
            <input type="url" name="video_url" class="form-control" placeholder="https://youtube.com/...">
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Marks</label>
            <input type="number" name="marks" class="form-control" value="1" min="1">
        </div>

        {{-- Options section for binary/single/multiple --}}
        <div id="options-section" class="d-none">
            <hr>
            <div class="d-flex justify-content-between align-items-center mb-2">
                <label class="fw-bold">Options</label>
                <button type="button" class="btn btn-sm btn-outline-primary" onclick="addOption()">+ Add Option</button>
            </div>
            <div id="options-list"></div>
        </div>

        {{-- Text/Number answer section --}}
        <div id="text-section" class="d-none">
            <hr>
            <label class="form-label fw-bold">Correct Answer</label>
            <input type="text" name="correct_answer" class="form-control">
        </div>

        <button class="btn btn-primary w-100 mt-3">Save Question</button>
    </form>
</div>
@endsection

@section('scripts')
<script>
let optionCount = 0;

document.getElementById('type').addEventListener('change', function() {
    const type = this.value;
    const optSec = document.getElementById('options-section');
    const txtSec = document.getElementById('text-section');
    const optList = document.getElementById('options-list');

    optSec.classList.add('d-none');
    txtSec.classList.add('d-none');
    optList.innerHTML = '';
    optionCount = 0;

    if (['binary', 'single', 'multiple'].includes(type)) {
        optSec.classList.remove('d-none');
        if (type === 'binary') {
            addOption('Yes'); addOption('No');
        } else {
            addOption(); addOption();
        }
    } else if (['text', 'number'].includes(type)) {
        txtSec.classList.remove('d-none');
    }
});

function addOption(defaultText = '') {
    const type = document.getElementById('type').value;
    const isMultiple = type === 'multiple';
    const inputType = isMultiple ? 'checkbox' : 'radio';
    const inputName = isMultiple ? 'is_correct[]' : 'is_correct';

    const div = document.createElement('div');
    div.className = 'card p-2 mb-2 border';
    div.innerHTML = `
        <div class="d-flex align-items-center gap-3">
            <div class="form-check">
                <input 
                    class="form-check-input" 
                    type="${inputType}" 
                    name="${inputName}" 
                    value="${optionCount}"
                    id="correct_${optionCount}">
                <label class="form-check-label text-success fw-bold" for="correct_${optionCount}">
                    Correct?
                </label>
            </div>
            <input 
                type="text" 
                name="options[${optionCount}]" 
                class="form-control" 
                placeholder="Type option text here" 
                value="${defaultText}" 
                required>
        </div>
    `;
    document.getElementById('options-list').appendChild(div);
    optionCount++;
}
</script>
@endsection