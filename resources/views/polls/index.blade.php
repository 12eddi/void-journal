@extends('layouts.app')

@section('title', 'Polls — VOID')

@section('styles')
<style>
    .poll-card {
        background: var(--surface);
        border: 1px solid var(--border);
        padding: 2rem;
        transition: border-color 0.2s;
    }

    .poll-card:hover { border-color: var(--accent2); }

    .poll-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
        gap: 1px;
        background: var(--border);
        max-width: 1200px;
        margin: 0 auto;
    }

    .poll-question {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 1.5rem;
        letter-spacing: 0.03em;
        color: var(--white);
        margin-bottom: 1.5rem;
        line-height: 1.1;
    }

    .poll-bar-wrap {
        margin-bottom: 0.6rem;
    }

    .poll-option-label {
        display: flex;
        justify-content: space-between;
        font-family: 'DM Mono', monospace;
        font-size: 0.65rem;
        letter-spacing: 0.08em;
        color: var(--muted);
        margin-bottom: 0.3rem;
    }

    .poll-bar {
        height: 2px;
        background: var(--border);
        position: relative;
    }

    .poll-bar-fill {
        height: 100%;
        background: var(--accent);
        transition: width 0.6s ease;
    }

    .poll-footer {
        margin-top: 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
</style>
@endsection

@section('content')
<div class="page-header">
    <div class="label">Community Voice</div>
    <h1>POLLS</h1>
</div>

<div style="padding: 2rem; max-width:1200px; margin:0 auto; display:flex; justify-content:flex-end;">
    @auth
    <a href="{{ route('polls.create') }}" class="btn btn-outline">+ New Poll</a>
    @endauth
</div>

@if($polls->isEmpty())
<div style="padding: 4rem 2rem; text-align:center;">
    <div class="mono text-muted">NO ACTIVE POLLS</div>
</div>
@else
<div class="poll-grid">
    @foreach($polls as $poll)
    @php $total = $poll->totalVotes(); @endphp
    <div class="poll-card">
        <div class="poll-question">{{ $poll->question }}</div>

        @foreach($poll->options as $option)
        @php $pct = $total > 0 ? round(($option->voteCount() / $total) * 100, 1) : 0; @endphp
        <div class="poll-bar-wrap">
            <div class="poll-option-label">
                <span>{{ $option->label }}</span>
                <span>{{ $pct }}%</span>
            </div>
            <div class="poll-bar">
                <div class="poll-bar-fill" style="width:{{ $pct }}%"></div>
            </div>
        </div>
        @endforeach

        <div class="poll-footer">
            <span class="mono text-muted">{{ $total }} votes</span>
            <a href="{{ route('polls.show', $poll) }}" class="btn btn-ghost" style="padding:0.4rem 1rem;">Vote →</a>
        </div>
    </div>
    @endforeach
</div>
@endif
@endsection
