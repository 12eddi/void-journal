@extends('layouts.app')

@section('title', 'New Poll — VOID')

@section('styles')
<style>
    .poll-create-wrap {
        max-width: 700px;
        margin: 0 auto;
        padding: 5rem 2rem;
    }

    .options-list { margin-top: 1rem; }

    .option-row {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 0.5rem;
    }

    .option-row input {
        flex: 1;
    }

    .remove-option {
        background: none;
        border: 1px solid var(--border);
        color: var(--muted);
        width: 36px;
        height: 36px;
        cursor: pointer;
        font-size: 1.2rem;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
        flex-shrink: 0;
        padding: 0;
    }

    .remove-option:hover { border-color: var(--danger); color: var(--danger); }
</style>
@endsection

@section('content')
<div class="poll-create-wrap">
    <a href="{{ route('polls.index') }}" class="btn btn-ghost" style="margin-bottom:3rem;display:inline-block;">← Polls</a>

    <div class="mono text-muted" style="font-size:0.65rem;letter-spacing:0.2em;margin-bottom:2rem;">NEW POLL</div>

    <form action="{{ route('polls.store') }}" method="POST" id="poll-form">
        @csrf

        <div class="form-group">
            <label>Question</label>
            <input type="text" name="question" value="{{ old('question') }}" 
                   placeholder="Ask the community..." required>
            @error('question')<div class="error-text">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label>Options <span class="mono text-muted">(min 2, max 6)</span></label>
            <div class="options-list" id="options-list">
                <div class="option-row">
                    <input type="text" name="options[]" placeholder="Option 1" value="{{ old('options.0') }}" required>
                </div>
                <div class="option-row">
                    <input type="text" name="options[]" placeholder="Option 2" value="{{ old('options.1') }}" required>
                </div>
            </div>
            <button type="button" class="btn btn-ghost" style="margin-top:0.8rem;" id="add-option">+ Add Option</button>
            @error('options')<div class="error-text">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label>End Date <span class="mono text-muted">(optional)</span></label>
            <input type="datetime-local" name="ends_at" value="{{ old('ends_at') }}">
        </div>

        <div style="margin-top:2.5rem;display:flex;gap:1rem;">
            <button type="submit" class="btn btn-primary">Create Poll</button>
            <a href="{{ route('polls.index') }}" class="btn btn-ghost">Cancel</a>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
const list = document.getElementById('options-list');
const addBtn = document.getElementById('add-option');
let count = 2;

addBtn.addEventListener('click', () => {
    if (count >= 6) return;
    count++;
    const row = document.createElement('div');
    row.className = 'option-row';
    row.innerHTML = `
        <input type="text" name="options[]" placeholder="Option ${count}">
        <button type="button" class="remove-option" onclick="this.parentElement.remove(); count--;">×</button>
    `;
    list.appendChild(row);
    if (count >= 6) addBtn.disabled = true;
});
</script>
@endsection
