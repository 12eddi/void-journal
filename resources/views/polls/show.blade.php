@extends('layouts.app')

@section('title', 'Poll — VOID')

@section('styles')
<style>
    .poll-wrap {
        max-width: 700px;
        margin: 0 auto;
        padding: 5rem 2rem;
    }

    .poll-big-question {
        font-family: 'Bebas Neue', sans-serif;
        font-size: clamp(2rem, 6vw, 4rem);
        letter-spacing: 0.03em;
        color: var(--white);
        line-height: 1.05;
        margin-bottom: 3rem;
    }

    .vote-option {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1.2rem 1.5rem;
        border: 1px solid var(--border);
        margin-bottom: 0.5rem;
        cursor: pointer;
        transition: all 0.2s;
        position: relative;
        overflow: hidden;
    }

    .vote-option:hover { border-color: var(--accent); }

    .vote-option input[type="radio"] {
        width: 16px;
        height: 16px;
        border: 1px solid var(--border);
        border-radius: 0;
        accent-color: var(--accent);
        flex-shrink: 0;
    }

    .vote-option-label {
        font-size: 0.9rem;
        color: var(--text);
        flex: 1;
    }

    /* Results mode */
    .result-option {
        margin-bottom: 1rem;
    }

    .result-label-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.4rem;
        font-family: 'DM Mono', monospace;
        font-size: 0.7rem;
        letter-spacing: 0.08em;
    }

    .result-bar {
        height: 3px;
        background: var(--surface2);
    }

    .result-bar-fill {
        height: 100%;
        background: var(--accent);
    }

    .result-winner .result-bar-fill {
        background: var(--white);
    }

    .result-winner .result-label-row {
        color: var(--white);
    }

    .poll-stats {
        display: flex;
        gap: 2rem;
        padding: 1.5rem 0;
        border-top: 1px solid var(--border);
        border-bottom: 1px solid var(--border);
        margin: 2rem 0;
    }

    .poll-stat {
        text-align: center;
    }

    .poll-stat-number {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 2rem;
        color: var(--white);
    }

    .poll-stat-label {
        font-family: 'DM Mono', monospace;
        font-size: 0.6rem;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: var(--muted);
    }
</style>
@endsection

@section('content')
<div class="poll-wrap">
    <a href="{{ route('polls.index') }}" class="btn btn-ghost" style="margin-bottom:3rem;display:inline-block;">← Polls</a>

    <div class="mono text-muted" style="margin-bottom:1rem;">{{ $poll->user->name }} — {{ $poll->created_at->format('d M Y') }}</div>

    <div class="poll-big-question">{{ $poll->question }}</div>

    @php
        $total = $poll->totalVotes();
        $hasVoted = auth()->check() && $poll->hasVoted(auth()->user());
        $showResults = $hasVoted || $poll->isExpired() || !$poll->is_active;
        $maxVotes = $poll->options->max(fn($o) => $o->voteCount());
    @endphp

    <div class="poll-stats">
        <div class="poll-stat">
            <div class="poll-stat-number">{{ $total }}</div>
            <div class="poll-stat-label">Total Votes</div>
        </div>
        <div class="poll-stat">
            <div class="poll-stat-number">{{ $poll->options->count() }}</div>
            <div class="poll-stat-label">Options</div>
        </div>
        @if($poll->ends_at)
        <div class="poll-stat">
            <div class="poll-stat-number">{{ $poll->isExpired() ? 'ENDED' : $poll->ends_at->diffForHumans() }}</div>
            <div class="poll-stat-label">{{ $poll->isExpired() ? 'Status' : 'Ends' }}</div>
        </div>
        @endif
    </div>

    @if($showResults)
        {{-- Show results --}}
        @foreach($poll->options as $option)
        @php
            $pct = $total > 0 ? round(($option->voteCount() / $total) * 100, 1) : 0;
            $isWinner = $option->voteCount() === $maxVotes && $maxVotes > 0;
        @endphp
        <div class="result-option {{ $isWinner ? 'result-winner' : '' }}">
            <div class="result-label-row">
                <span>{{ $option->label }} @if($isWinner) ←@endif</span>
                <span>{{ $pct }}% ({{ $option->voteCount() }})</span>
            </div>
            <div class="result-bar">
                <div class="result-bar-fill" style="width:{{ $pct }}%"></div>
            </div>
        </div>
        @endforeach

        @if($hasVoted)
        <div class="mono text-muted mt-4" style="font-size:0.65rem;letter-spacing:0.1em;">YOU HAVE VOTED</div>
        @endif
    @else
        {{-- Voting form --}}
        @auth
        <form action="{{ route('polls.vote', $poll) }}" method="POST">
            @csrf
            @foreach($poll->options as $option)
            <label class="vote-option">
                <input type="radio" name="option_id" value="{{ $option->id }}" required>
                <span class="vote-option-label">{{ $option->label }}</span>
            </label>
            @endforeach

            <div style="margin-top:2rem;">
                <button type="submit" class="btn btn-primary">Cast Vote</button>
            </div>
        </form>
        @else
        <div style="border:1px solid var(--border);padding:2rem;text-align:center;">
            <div class="mono text-muted" style="margin-bottom:1rem;">LOGIN TO VOTE</div>
            <a href="{{ route('login') }}" class="btn btn-outline">Login</a>
        </div>
        @endauth
    @endif

    @auth
    @if(auth()->user()->isAdmin())
    <div style="margin-top:3rem;padding-top:2rem;border-top:1px solid var(--border);">
        <form action="{{ route('polls.destroy', $poll) }}" method="POST" onsubmit="return confirm('Delete this poll?')">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete Poll</button>
        </form>
    </div>
    @endif
    @endauth
</div>
@endsection
