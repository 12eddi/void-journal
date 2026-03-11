@extends('layouts.app')

@section('title', 'VOID — JOURNAL')

@section('styles')
<style>
    .hero {
        padding: 8rem 2rem 4rem;
        max-width: 1200px;
        margin: 0 auto;
        border-bottom: 1px solid var(--border);
    }

    .hero-label {
        font-family: 'DM Mono', monospace;
        font-size: 0.65rem;
        letter-spacing: 0.3em;
        text-transform: uppercase;
        color: var(--muted);
        margin-bottom: 2rem;
    }

    .hero-title {
        font-family: 'Bebas Neue', sans-serif;
        font-size: clamp(5rem, 15vw, 12rem);
        line-height: 0.85;
        letter-spacing: -0.01em;
        color: var(--white);
        margin-bottom: 2rem;
    }

    .hero-sub {
        font-size: 0.9rem;
        color: var(--muted);
        max-width: 400px;
        font-weight: 300;
    }

    .articles-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(360px, 1fr));
        gap: 1px;
        background: var(--border);
        margin-top: 0;
    }

    .article-card {
        background: var(--surface);
        padding: 2.5rem;
        display: flex;
        flex-direction: column;
        gap: 1.2rem;
        transition: background 0.2s;
        text-decoration: none;
    }

    .article-card:hover { background: var(--surface2); }

    .article-meta {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .article-author {
        font-family: 'DM Mono', monospace;
        font-size: 0.65rem;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: var(--muted);
    }

    .article-date {
        font-family: 'DM Mono', monospace;
        font-size: 0.65rem;
        color: var(--muted);
        margin-left: auto;
    }

    .article-title {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 1.8rem;
        letter-spacing: 0.03em;
        color: var(--white);
        line-height: 1.1;
    }

    .article-excerpt {
        font-size: 0.85rem;
        color: var(--muted);
        line-height: 1.6;
    }

    .article-readmore {
        font-family: 'DM Mono', monospace;
        font-size: 0.65rem;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: var(--accent);
        margin-top: auto;
    }

    .section-header {
        padding: 3rem 2rem 2rem;
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
    }

    .section-label {
        font-family: 'DM Mono', monospace;
        font-size: 0.65rem;
        letter-spacing: 0.2em;
        text-transform: uppercase;
        color: var(--muted);
        margin-bottom: 0.5rem;
    }

    .section-title {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 2.5rem;
        letter-spacing: 0.05em;
        color: var(--white);
    }

    .pagination-wrap {
        padding: 2rem;
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        gap: 0.5rem;
    }

    .pagination-wrap a, .pagination-wrap span {
        font-family: 'DM Mono', monospace;
        font-size: 0.65rem;
        letter-spacing: 0.1em;
        padding: 0.5rem 0.9rem;
        border: 1px solid var(--border);
        color: var(--muted);
        text-decoration: none;
        transition: all 0.2s;
    }

    .pagination-wrap a:hover { border-color: var(--accent); color: var(--accent); }
    .pagination-wrap .active { border-color: var(--accent); color: var(--accent); }
</style>
@endsection

@section('content')
<div class="hero">
    <div class="hero-label">Est. {{ date('Y') }} — The journal of record</div>
    <h1 class="hero-title">VOID<br>JOURNAL</h1>
    <p class="hero-sub">Words cut through noise. Thoughts sharp enough to leave marks.</p>
</div>

<div class="section-header">
    <div>
        <div class="section-label">Latest</div>
        <div class="section-title">ARTICLES</div>
    </div>
    @auth
    <a href="{{ route('articles.create') }}" class="btn btn-outline">+ New Article</a>
    @endauth
</div>

@if($articles->isEmpty())
<div style="padding: 4rem 2rem; max-width:1200px; margin:0 auto; text-align:center;">
    <div class="mono" style="color:var(--muted);">NO ARTICLES YET — BE THE FIRST</div>
</div>
@else
<div class="articles-grid" style="max-width:1200px;margin:0 auto 0;">
    @foreach($articles as $article)
    <a href="{{ route('articles.show', $article) }}" class="article-card">
        <div class="article-meta">
            <span class="article-author">{{ $article->user->name }}</span>
            <span class="article-date">{{ $article->created_at->format('d.m.y') }}</span>
        </div>
        <div class="article-title">{{ $article->title }}</div>
        <div class="article-excerpt">{{ $article->excerpt }}</div>
        <span class="article-readmore">Read → </span>
    </a>
    @endforeach
</div>

<div class="pagination-wrap">
    {{ $articles->links() }}
</div>
@endif
@endsection
