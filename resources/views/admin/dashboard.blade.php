@extends('layouts.app')

@section('title', 'Admin — VOID')

@section('styles')
<style>
    .admin-layout {
        display: grid;
        grid-template-columns: 220px 1fr;
        min-height: calc(100vh - 60px);
    }

    .admin-sidebar {
        border-right: 1px solid var(--border);
        padding: 3rem 0;
        background: var(--surface);
        position: sticky;
        top: 60px;
        height: calc(100vh - 60px);
    }

    .admin-sidebar-label {
        font-family: 'DM Mono', monospace;
        font-size: 0.55rem;
        letter-spacing: 0.2em;
        text-transform: uppercase;
        color: var(--muted);
        padding: 0 1.5rem;
        margin-bottom: 1rem;
    }

    .admin-nav-item {
        display: block;
        padding: 0.7rem 1.5rem;
        font-family: 'DM Mono', monospace;
        font-size: 0.7rem;
        letter-spacing: 0.08em;
        color: var(--muted);
        text-decoration: none;
        transition: all 0.2s;
        border-left: 2px solid transparent;
    }

    .admin-nav-item:hover, .admin-nav-item.active {
        color: var(--accent);
        border-left-color: var(--accent);
        background: rgba(200, 184, 154, 0.03);
    }

    .admin-main {
        padding: 3rem;
    }

    .admin-title {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 3rem;
        letter-spacing: 0.05em;
        color: var(--white);
        margin-bottom: 0.5rem;
    }

    .admin-subtitle {
        font-family: 'DM Mono', monospace;
        font-size: 0.65rem;
        letter-spacing: 0.12em;
        color: var(--muted);
        margin-bottom: 3rem;
    }

    .stats-row {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1px;
        background: var(--border);
        margin-bottom: 3rem;
    }

    .stat-box {
        background: var(--surface);
        padding: 2rem;
    }

    .stat-num {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 3rem;
        color: var(--white);
        line-height: 1;
    }

    .stat-label {
        font-family: 'DM Mono', monospace;
        font-size: 0.6rem;
        letter-spacing: 0.15em;
        text-transform: uppercase;
        color: var(--muted);
        margin-top: 0.5rem;
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 1rem;
    }

    .data-table th {
        font-family: 'DM Mono', monospace;
        font-size: 0.6rem;
        letter-spacing: 0.15em;
        text-transform: uppercase;
        color: var(--muted);
        padding: 0.7rem 1rem;
        text-align: left;
        border-bottom: 1px solid var(--border);
    }

    .data-table td {
        padding: 0.9rem 1rem;
        border-bottom: 1px solid var(--border);
        font-size: 0.85rem;
        color: var(--text);
        vertical-align: middle;
    }

    .data-table tr:hover td { background: var(--surface2); }

    .section-block {
        margin-bottom: 3rem;
    }

    .section-block-title {
        font-family: 'DM Mono', monospace;
        font-size: 0.65rem;
        letter-spacing: 0.15em;
        text-transform: uppercase;
        color: var(--muted);
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid var(--border);
    }

    .role-badge {
        display: inline-block;
        font-family: 'DM Mono', monospace;
        font-size: 0.55rem;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        padding: 0.2rem 0.5rem;
        border: 1px solid;
    }

    .role-admin { color: var(--accent); border-color: var(--accent2); }
    .role-user { color: var(--muted); border-color: var(--border); }
</style>
@endsection

@section('content')
<div class="admin-layout">
    <div class="admin-sidebar">
        <div class="admin-sidebar-label">Admin Panel</div>
        <a href="{{ route('admin.dashboard') }}" class="admin-nav-item active">Dashboard</a>
        <a href="{{ route('admin.users') }}" class="admin-nav-item">Users</a>
        <a href="{{ route('articles.index') }}" class="admin-nav-item">Articles</a>
        <a href="{{ route('polls.index') }}" class="admin-nav-item">Polls</a>
    </div>

    <div class="admin-main">
        <div class="admin-title">DASHBOARD</div>
        <div class="admin-subtitle">SYSTEM OVERVIEW — {{ now()->format('d M Y') }}</div>

        <div class="stats-row">
            <div class="stat-box">
                <div class="stat-num">{{ $stats['users'] }}</div>
                <div class="stat-label">Users</div>
            </div>
            <div class="stat-box">
                <div class="stat-num">{{ $stats['articles'] }}</div>
                <div class="stat-label">Articles</div>
            </div>
            <div class="stat-box">
                <div class="stat-num">{{ $stats['polls'] }}</div>
                <div class="stat-label">Polls</div>
            </div>
            <div class="stat-box">
                <div class="stat-num">{{ $stats['votes'] }}</div>
                <div class="stat-label">Votes Cast</div>
            </div>
        </div>

        <div class="section-block">
            <div class="section-block-title">Recent Users</div>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Joined</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentUsers as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td class="mono" style="font-size:0.75rem;color:var(--muted);">{{ $user->email }}</td>
                        <td><span class="role-badge role-{{ $user->role }}">{{ $user->role }}</span></td>
                        <td class="mono" style="font-size:0.7rem;color:var(--muted);">{{ $user->created_at->format('d M Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div style="margin-top:1rem;">
                <a href="{{ route('admin.users') }}" class="btn btn-ghost">View All Users →</a>
            </div>
        </div>

        <div class="section-block">
            <div class="section-block-title">Recent Articles</div>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentArticles as $article)
                    <tr>
                        <td>{{ Str::limit($article->title, 40) }}</td>
                        <td class="mono" style="font-size:0.7rem;color:var(--muted);">{{ $article->user->name }}</td>
                        <td><span class="tag">{{ $article->status }}</span></td>
                        <td class="mono" style="font-size:0.7rem;color:var(--muted);">{{ $article->created_at->format('d M Y') }}</td>
                        <td>
                            <a href="{{ route('articles.show', $article) }}" class="btn btn-ghost" style="padding:0.3rem 0.7rem;font-size:0.6rem;">View</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
