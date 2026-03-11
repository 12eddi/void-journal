@extends('layouts.app')

@section('title', 'Write — VOID')

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
        overflow-y: auto;
    }

    .write-label {
        font-family: 'DM Mono', monospace;
        font-size: 0.65rem;
        letter-spacing: 0.2em;
        text-transform: uppercase;
        color: var(--muted);
        margin-bottom: 3rem;
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

    input[type="text"]#title::placeholder {
        color: var(--border);
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

    textarea#body:focus {
        border: none;
        outline: none;
    }

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

    .upload-zone {
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        width: 100%;
        height: 140px;
        border: 1px dashed var(--border);
        cursor: pointer;
        transition: border-color 0.2s;
        overflow: hidden;
        position: relative;
    }

    .upload-zone:hover { border-color: var(--accent); }

    @media (max-width: 768px) {
        .write-wrap { grid-template-columns: 1fr; }
        .write-sidebar {
            position: static;
            height: auto;
            border-top: 1px solid var(--border);
        }
    }
</style>
@endsection

@section('content')
<form action="{{ route('articles.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="write-wrap">
        <div class="write-main">
            <div class="write-label">New Article</div>

            <div class="form-group">
                <input type="text" name="title" id="title" placeholder="Title goes here..."
                       value="{{ old('title') }}" required autocomplete="off">
                @error('title')<div class="error-text">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <textarea name="body" id="body"
                          placeholder="Start writing...">{{ old('body') }}</textarea>
                @error('body')<div class="error-text">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="write-sidebar">

            <div class="sidebar-section">
                <div class="sidebar-title">Cover Image</div>
                <label for="cover_image" class="upload-zone" id="upload-zone">
                    <div id="upload-placeholder" style="padding:1rem;">
                        <div style="font-size:1.5rem;margin-bottom:0.5rem;color:var(--muted);">+</div>
                        <div class="mono" style="font-size:0.6rem;letter-spacing:0.1em;color:var(--muted);">UPLOAD IMAGE</div>
                        <div class="mono" style="font-size:0.55rem;margin-top:0.3rem;color:var(--muted);">JPG, PNG, WEBP — max 4MB</div>
                    </div>
                    <img id="image-preview" src="" style="display:none;width:100%;height:100%;object-fit:cover;" />
                </label>
                <input type="file" name="cover_image" id="cover_image" accept="image/*" style="display:none;">
                @error('cover_image')<div class="error-text">{{ $message }}</div>@enderror
            </div>

            <div class="sidebar-section">
                <div class="sidebar-title">Status</div>
                <select name="status">
                    <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                    <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                </select>
            </div>

            <div class="sidebar-section">
                <div class="sidebar-title">Author</div>
                <div class="mono" style="font-size:0.75rem;">{{ auth()->user()->name }}</div>
                <div class="mono text-muted" style="margin-top:0.3rem;">{{ auth()->user()->role }}</div>
            </div>

            <div class="sidebar-section">
                <button type="submit" class="btn btn-primary" style="width:100%;">Publish Article</button>
                <a href="{{ route('articles.index') }}" class="btn btn-ghost" style="width:100%;margin-top:0.5rem;text-align:center;">Cancel</a>
            </div>

        </div>
    </div>
</form>
@endsection

@section('scripts')
<script>
document.getElementById('cover_image').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = function(ev) {
        document.getElementById('upload-placeholder').style.display = 'none';
        const preview = document.getElementById('image-preview');
        preview.src = ev.target.result;
        preview.style.display = 'block';
    };
    reader.readAsDataURL(file);
});
</script>
@endsection