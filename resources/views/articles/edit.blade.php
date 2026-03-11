@extends('layouts.app')

@section('title', 'Edit — VOID')

@section('styles')
<style>
    .write-wrap {
        display: grid;
        grid-template-columns: 1fr 300px;
        gap: 0;
        min-height: calc(100vh - 60px);
    }

    .write-main {
        padding: 5rem 3rem;
        border-right: 1px solid var(--border);
    }

    .write-sidebar {
        padding: 5rem 2rem;
        position: sticky;
        top: 60px;
        height: calc(100vh - 60px);
    }

    input[type="text"]#title {
        background: transparent;
        border: none;
        border-bottom: 1px solid var(--border);
        font-family: 'Bebas Neue', sans-serif;
        font-size: 2.5rem;
        letter-spacing: 0.03em;
        color: var(--white);
        padding: 0.5rem 0;
        margin-bottom: 2rem;
    }

    input[type="text"]#title:focus {
        border-bottom-color: var(--accent);
        outline: none;
    }

    textarea#body {
        background: transparent;
        border: none;
        font-size: 0.95rem;
        line-height: 1.85;
        color: var(--text);
        min-height: 50vh;
        padding: 0;
        resize: none;
    }

    textarea#body:focus { border: none; outline: none; }

    .sidebar-section {
        margin-bottom: 2rem;
        padding-bottom: 2rem;
        border-bottom: 1px solid var(--border);
    }

    .sidebar-section:last-child { border-bottom: none; }

    .sidebar-title {
        font-family: 'DM Mono', monospace;
        font-size: 0.6rem;
        letter-spacing: 0.15em;
        text-transform: uppercase;
        color: var(--muted);
        margin-bottom: 1rem;
    }
</style>
@endsection

@section('content')
<form action="{{ route('articles.update', $article) }}" method="POST">
    @csrf @method('PUT')
    <div class="write-wrap">
        <div class="write-main">
            <div class="write-label" style="font-family:'DM Mono',monospace;font-size:0.65rem;letter-spacing:0.2em;text-transform:uppercase;color:var(--muted);margin-bottom:3rem;">
                Editing Article
            </div>

            <div class="form-group">
                <input type="text" name="title" id="title" 
                       value="{{ old('title', $article->title) }}" required>
                @error('title')<div class="error-text">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <textarea name="body" id="body">{{ old('body', $article->body) }}</textarea>
                @error('body')<div class="error-text">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="write-sidebar">
            <div class="sidebar-section">
                <div class="sidebar-title">Status</div>
                <select name="status">
                    <option value="published" {{ $article->status == 'published' ? 'selected' : '' }}>Published</option>
                    <option value="draft" {{ $article->status == 'draft' ? 'selected' : '' }}>Draft</option>
                </select>
            </div>

            <div class="sidebar-section">
                <button type="submit" class="btn btn-primary" style="width:100%;">Save Changes</button>
                <a href="{{ route('articles.show', $article) }}" class="btn btn-ghost" style="width:100%;margin-top:0.5rem;text-align:center;">Cancel</a>
            </div>
        </div>
    </div>
</form>
@endsection
