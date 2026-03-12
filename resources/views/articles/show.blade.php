@extends('layouts.app')

@section('title', $article->title . ' — VOID')

@section('styles')
<style>
    .article-hero {
        padding: 7rem 2rem 4rem;
        max-width: 800px;
        margin: 0 auto;
        border-bottom: 1px solid var(--border);
    }

    .back-link {
        font-family: 'DM Mono', monospace;
        font-size: 0.65rem;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: var(--muted);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 3rem;
        transition: color 0.2s;
    }

    .back-link:hover { color: var(--accent); }

    .article-meta-row {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .article-hero-title {
        font-family: 'Bebas Neue', sans-serif;
        font-size: clamp(2.5rem, 7vw, 5rem);
        line-height: 0.95;
        letter-spacing: 0.02em;
        color: var(--white);
    }

    .article-cover {
        max-width: 800px;
        margin: 0 auto;
        padding: 2rem 2rem 0;
    }

    .article-cover img {
        width: 100%;
        max-height: 500px;
        object-fit: cover;
        border: 1px solid var(--border);
        display: block;
    }

    .article-body {
        max-width: 800px;
        margin: 0 auto;
        padding: 4rem 2rem;
        font-size: 1rem;
        line-height: 1.85;
        color: #c8c4bf;
    }

    .article-body p { margin-bottom: 1.5rem; }
    .article-body h2, .article-body h3 {
        font-family: 'Bebas Neue', sans-serif;
        letter-spacing: 0.05em;
        color: var(--white);
        margin: 2rem 0 1rem;
    }

    .article-actions {
        max-width: 800px;
        margin: 0 auto;
        padding: 2rem;
        border-top: 1px solid var(--border);
        display: flex;
        gap: 1rem;
    }

    .author-card {
        max-width: 800px;
        margin: 0 auto 2rem;
        padding: 0 2rem;
    }

    .author-inner {
        border: 1px solid var(--border);
        padding: 1.5rem;
        display: flex;
        align-items: center;
        gap: 1.5rem;
    }

    .author-avatar {
        width: 48px;
        height: 48px;
        background: var(--surface2);
        border: 1px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'Bebas Neue', sans-serif;
        font-size: 1.2rem;
        color: var(--accent);
        flex-shrink: 0;
    }

    .author-name {
        font-family: 'DM Mono', monospace;
        font-size: 0.75rem;
        letter-spacing: 0.1em;
        color: var(--text);
    }

    .author-role {
        font-family: 'DM Mono', monospace;
        font-size: 0.6rem;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: var(--muted);
        margin-top: 0.2rem;
    }

    .comment-textarea {
        min-height: 100px;
        background: var(--surface);
        border: 1px solid var(--border);
        padding: 1rem;
        width: 100%;
        color: var(--text);
        font-family: 'Hanken Grotesk', sans-serif;
        font-size: 0.9rem;
        resize: none;
        outline: none;
        transition: border-color 0.2s;
    }

    .comment-textarea:focus { border-color: var(--accent); }
</style>
@endsection

@section('content')
<div class="article-hero">
    <a href="{{ route('articles.index') }}" class="back-link">← Back</a>

    <div class="article-meta-row">
        <span class="tag">{{ $article->status }}</span>
        <span class="mono text-muted">{{ $article->created_at->format('d M Y') }}</span>
    </div>

    <h1 class="article-hero-title">{{ $article->title }}</h1>
</div>

@if($article->cover_image)
<div class="article-cover">
    <img src="{{ \Illuminate\Support\Facades\Storage::url($article->cover_image) }}" alt="{{ $article->title }}">
</div>
@endif

<div class="article-body">
    {!! nl2br(e($article->body)) !!}
</div>

@auth
@if(auth()->user()->isAdmin() || $article->user_id === auth()->id())
<div class="article-actions">
    <a href="{{ route('articles.edit', $article) }}" class="btn btn-ghost">Edit</a>
    @if(auth()->user()->isAdmin())
    <form action="{{ route('articles.destroy', $article) }}" method="POST" onsubmit="return confirm('Delete this article?')">
        @csrf @method('DELETE')
        <button type="submit" class="btn btn-danger">Delete</button>
    </form>
    @endif
</div>
@endif
@endauth

<div class="author-card">
    <div class="author-inner">
        <div class="author-avatar">{{ strtoupper(substr($article->user->name, 0, 1)) }}</div>
        <div>
            <div class="author-name">{{ $article->user->name }}</div>
            <div class="author-role">{{ $article->user->isAdmin() ? 'ADMIN' : 'CONTRIBUTOR' }}</div>
        </div>
        <div style="margin-left:auto;">
            <span class="mono text-muted">{{ $article->user->articles()->count() }} articles</span>
        </div>
    </div>
</div>

{{-- COMMENTS SECTION --}}
<div style="max-width:800px;margin:0 auto;padding:0 2rem 4rem;">

    <div style="border-top:1px solid var(--border);padding-top:3rem;margin-bottom:2rem;">
        <div class="mono text-muted" style="font-size:0.65rem;letter-spacing:0.2em;margin-bottom:0.5rem;">DISCUSSION</div>
        <div style="font-family:'Bebas Neue',sans-serif;font-size:2rem;color:var(--white);">
            {{ $article->comments->count() }} COMMENTS
        </div>
    </div>

    @auth
    <form action="{{ route('comments.store', $article) }}" method="POST" style="margin-bottom:3rem;">
        @csrf
        <div class="form-group">
            <textarea name="body" class="comment-textarea"
                      placeholder="Leave a comment..."
                      required>{{ old('body') }}</textarea>
            @error('body')<div class="error-text">{{ $message }}</div>@enderror
        </div>
        <button type="submit" class="btn btn-outline">Post Comment</button>
    </form>
    @else
    <div style="border:1px solid var(--border);padding:1.5rem;margin-bottom:3rem;text-align:center;">
        <span class="mono text-muted" style="font-size:0.7rem;">
            <a href="{{ route('login') }}" style="color:var(--accent);">LOGIN</a> TO COMMENT
        </span>
    </div>
    @endauth

    @forelse($article->comments as $comment)
    <div style="border-bottom:1px solid var(--border);padding:1.5rem 0;display:flex;gap:1rem;">
        <div style="width:36px;height:36px;background:var(--surface2);border:1px solid var(--border);display:flex;align-items:center;justify-content:center;font-family:'Bebas Neue',sans-serif;color:var(--accent);flex-shrink:0;">
            {{ strtoupper(substr($comment->user->name, 0, 1)) }}
        </div>
        <div style="flex:1;">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:0.5rem;">
                <span class="mono" style="font-size:0.7rem;color:var(--text);">{{ $comment->user->name }}</span>
                <span class="mono text-muted" style="font-size:0.6rem;">{{ $comment->created_at->diffForHumans() }}</span>
            </div>
            <div style="font-size:0.9rem;color:#c8c4bf;line-height:1.6;">{{ $comment->body }}</div>
            @auth
            @if(auth()->user()->isAdmin() || $comment->user_id === auth()->id())
            <form action="{{ route('comments.destroy', $comment) }}" method="POST" style="margin-top:0.5rem;">
                @csrf @method('DELETE')
                <button type="submit" style="background:none;border:none;cursor:pointer;font-family:'DM Mono',monospace;font-size:0.6rem;letter-spacing:0.1em;color:var(--muted);text-transform:uppercase;">
                    Delete
                </button>
            </form>
            @endif
            @endauth
        </div>
    </div>
    @empty
    <div class="mono text-muted" style="font-size:0.7rem;text-align:center;padding:2rem 0;">
        NO COMMENTS YET — BE THE FIRST
    </div>
    @endforelse

</div>
@endsection