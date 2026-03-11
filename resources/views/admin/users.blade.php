@extends('layouts.app')

@section('title', 'Users — Admin — VOID')

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

    .admin-main { padding: 3rem; }

    .admin-title {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 3rem;
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

    .data-table {
        width: 100%;
        border-collapse: collapse;
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

    .action-row { display: flex; gap: 0.4rem; align-items: center; }
</style>
@endsection

@section('content')
<div class="admin-layout">
    <div class="admin-sidebar">
        <div class="admin-sidebar-label">Admin Panel</div>
        <a href="{{ route('admin.dashboard') }}" class="admin-nav-item">Dashboard</a>
        <a href="{{ route('admin.users') }}" class="admin-nav-item active">Users</a>
        <a href="{{ route('articles.index') }}" class="admin-nav-item">Articles</a>
        <a href="{{ route('polls.index') }}" class="admin-nav-item">Polls</a>
    </div>

    <div class="admin-main">
        <div class="admin-title">USERS</div>
        <div class="admin-subtitle">{{ $users->total() }} TOTAL MEMBERS</div>

        <table class="data-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Articles</th>
                    <th>Joined</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td class="mono" style="color:var(--muted);font-size:0.7rem;">{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td class="mono" style="font-size:0.7rem;color:var(--muted);">{{ $user->email }}</td>
                    <td><span class="role-badge role-{{ $user->role }}">{{ $user->role }}</span></td>
                    <td class="mono" style="font-size:0.75rem;color:var(--muted);">{{ $user->articles()->count() }}</td>
                    <td class="mono" style="font-size:0.7rem;color:var(--muted);">{{ $user->created_at->format('d M Y') }}</td>
                    <td>
                        @if($user->id !== auth()->id())
                        <div class="action-row">
                            @if($user->role === 'user')
                            <form action="{{ route('admin.users.promote', $user) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-ghost" style="padding:0.3rem 0.7rem;font-size:0.6rem;">Promote</button>
                            </form>
                            @else
                            <form action="{{ route('admin.users.demote', $user) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-ghost" style="padding:0.3rem 0.7rem;font-size:0.6rem;">Demote</button>
                            </form>
                            @endif
                            <form action="{{ route('admin.users.delete', $user) }}" method="POST" 
                                  onsubmit="return confirm('Delete {{ $user->name }}?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger" style="padding:0.3rem 0.7rem;font-size:0.6rem;">Del</button>
                            </form>
                        </div>
                        @else
                        <span class="mono text-muted" style="font-size:0.6rem;">YOU</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div style="margin-top:2rem;">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection
