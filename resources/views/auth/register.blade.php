@extends('layouts.app')

@section('title', 'Join — VOID')

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
        <div class="auth-big">JOIN<br>VOID</div>
        <p class="auth-desc">Add your voice to the record. Write what matters. Vote on what defines.</p>
    </div>

    <div class="auth-right">
        <div class="auth-title">Create Account</div>

        <form action="{{ route('register') }}" method="POST">
            @csrf

            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" value="{{ old('name') }}" 
                       placeholder="Your name" required autofocus>
                @error('name')<div class="error-text">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email') }}" 
                       placeholder="you@example.com" required>
                @error('email')<div class="error-text">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Min. 8 characters" required>
                @error('password')<div class="error-text">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="password_confirmation" placeholder="Repeat password" required>
            </div>

            <button type="submit" class="btn btn-primary" style="width:100%;">Create Account</button>
        </form>

        <div class="auth-footer">
            Already a member? <a href="{{ route('login') }}">Sign in →</a>
        </div>
    </div>
</div>
@endsection
