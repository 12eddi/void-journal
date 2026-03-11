@extends('layouts.app')

@section('title', 'Login — VOID')

@section('styles')
<style>
    .auth-wrap {
        min-height: calc(100vh - 60px);
        display: grid;
        grid-template-columns: 1fr 1fr;
    }

    .auth-left {
        background: var(--surface);
        border-right: 1px solid var(--border);
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 4rem;
    }

    .auth-big {
        font-family: 'Bebas Neue', sans-serif;
        font-size: clamp(4rem, 10vw, 9rem);
        line-height: 0.85;
        color: var(--white);
        margin-bottom: 2rem;
    }

    .auth-desc {
        font-size: 0.85rem;
        color: var(--muted);
        max-width: 300px;
        line-height: 1.7;
    }

    .auth-right {
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 4rem;
        max-width: 480px;
        width: 100%;
        margin: 0 auto;
    }

    .auth-title {
        font-family: 'DM Mono', monospace;
        font-size: 0.65rem;
        letter-spacing: 0.2em;
        text-transform: uppercase;
        color: var(--muted);
        margin-bottom: 3rem;
    }

    .auth-footer {
        margin-top: 2rem;
        font-family: 'DM Mono', monospace;
        font-size: 0.65rem;
        letter-spacing: 0.08em;
        color: var(--muted);
    }

    .auth-footer a {
        color: var(--accent);
        text-decoration: none;
    }

    @media (max-width: 768px) {
        .auth-wrap { grid-template-columns: 1fr; }
        .auth-left { display: none; }
        .auth-right { padding: 4rem 2rem; }
    }
</style>
@endsection

@section('content')
<div class="auth-wrap">
    <div class="auth-left">
        <div class="auth-big">SIGN<br>IN</div>
        <p class="auth-desc">Return to where you left off. Your words are waiting.</p>
    </div>

    <div class="auth-right">
        <div class="auth-title">Authentication Required</div>

        <form action="{{ route('login') }}" method="POST">
            @csrf

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email') }}" 
                       placeholder="you@example.com" required autofocus>
                @error('email')<div class="error-text">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="••••••••" required>
                @error('password')<div class="error-text">{{ $message }}</div>@enderror
            </div>

            <div style="display:flex;align-items:center;gap:0.8rem;margin-bottom:2rem;">
                <input type="checkbox" name="remember" id="remember" style="accent-color:var(--accent);">
                <label for="remember" style="font-size:0.75rem;text-transform:none;letter-spacing:0;">
                    Remember me
                </label>
            </div>

            <button type="submit" class="btn btn-primary" style="width:100%;">Enter</button>
        </form>

        <div class="auth-footer">
            No account? <a href="{{ route('register') }}">Create one →</a>
        </div>
    </div>
</div>
@endsection
