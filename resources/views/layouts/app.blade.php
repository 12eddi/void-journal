<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'VOID — JOURNAL')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Mono:ital,wght@0,300;0,400;1,300&family=Hanken+Grotesk:wght@300;400;500&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg: #0a0a0a;
            --surface: #111111;
            --surface2: #1a1a1a;
            --border: #222222;
            --text: #e8e4df;
            --muted: #555555;
            --accent: #c8b89a;
            --accent2: #8a7a6a;
            --white: #f5f0eb;
            --danger: #8b3a3a;
        }

        html { scroll-behavior: smooth; }

        body {
            background: var(--bg);
            color: var(--text);
            font-family: 'Hanken Grotesk', sans-serif;
            font-weight: 300;
            font-size: 15px;
            line-height: 1.7;
            min-height: 100vh;
        }

        /* NAV */
        nav {
            position: fixed;
            top: 0; left: 0; right: 0;
            z-index: 100;
            background: rgba(10,10,10,0.95);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border);
            padding: 0 2rem;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .nav-logo {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 1.5rem;
            letter-spacing: 0.15em;
            color: var(--white);
            text-decoration: none;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 2.5rem;
            list-style: none;
        }

        .nav-links a {
            font-family: 'DM Mono', monospace;
            font-size: 0.7rem;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--muted);
            text-decoration: none;
            transition: color 0.2s;
        }

        .nav-links a:hover { color: var(--accent); }

        .nav-links .nav-highlight {
            color: var(--accent);
            border: 1px solid var(--accent);
            padding: 0.35rem 0.9rem;
        }

        .nav-links .nav-highlight:hover {
            background: var(--accent);
            color: var(--bg);
        }

        /* MAIN */
        main {
            padding-top: 60px;
            min-height: 100vh;
        }

        /* SECTIONS */
        .section {
            padding: 4rem 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        /* PAGE HEADER */
        .page-header {
            border-bottom: 1px solid var(--border);
            padding: 5rem 2rem 3rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .page-header .label {
            font-family: 'DM Mono', monospace;
            font-size: 0.65rem;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: var(--muted);
            margin-bottom: 1rem;
        }

        .page-header h1 {
            font-family: 'Bebas Neue', sans-serif;
            font-size: clamp(3rem, 8vw, 7rem);
            letter-spacing: 0.05em;
            line-height: 0.9;
            color: var(--white);
        }

        /* CARDS */
        .card {
            background: var(--surface);
            border: 1px solid var(--border);
            padding: 2rem;
            transition: border-color 0.2s, transform 0.2s;
        }

        .card:hover {
            border-color: var(--accent2);
            transform: translateY(-2px);
        }

        .card-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
            gap: 1px;
            background: var(--border);
        }

        .card-grid .card {
            background: var(--surface);
        }

        /* TYPOGRAPHY */
        .mono {
            font-family: 'DM Mono', monospace;
            font-size: 0.7rem;
            letter-spacing: 0.1em;
        }

        .display {
            font-family: 'Bebas Neue', sans-serif;
            letter-spacing: 0.05em;
        }

        h1, h2, h3 { font-weight: 400; }

        /* BUTTONS */
        .btn {
            display: inline-block;
            padding: 0.75rem 2rem;
            font-family: 'DM Mono', monospace;
            font-size: 0.7rem;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            text-decoration: none;
            cursor: pointer;
            border: none;
            transition: all 0.2s;
        }

        .btn-primary {
            background: var(--accent);
            color: var(--bg);
        }

        .btn-primary:hover {
            background: var(--white);
        }

        .btn-outline {
            background: transparent;
            color: var(--accent);
            border: 1px solid var(--accent);
        }

        .btn-outline:hover {
            background: var(--accent);
            color: var(--bg);
        }

        .btn-ghost {
            background: transparent;
            color: var(--muted);
            border: 1px solid var(--border);
        }

        .btn-ghost:hover {
            color: var(--text);
            border-color: var(--muted);
        }

        .btn-danger {
            background: transparent;
            color: var(--danger);
            border: 1px solid var(--danger);
        }

        .btn-danger:hover {
            background: var(--danger);
            color: var(--white);
        }

        /* FORMS */
        .form-group {
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            font-family: 'DM Mono', monospace;
            font-size: 0.65rem;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: var(--muted);
            margin-bottom: 0.5rem;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="date"],
        input[type="datetime-local"],
        textarea,
        select {
            width: 100%;
            background: var(--surface2);
            border: 1px solid var(--border);
            color: var(--text);
            padding: 0.85rem 1rem;
            font-family: 'Hanken Grotesk', sans-serif;
            font-size: 0.9rem;
            font-weight: 300;
            outline: none;
            transition: border-color 0.2s;
            appearance: none;
        }

        input:focus, textarea:focus, select:focus {
            border-color: var(--accent);
        }

        textarea { resize: vertical; min-height: 200px; }

        .error-text {
            font-family: 'DM Mono', monospace;
            font-size: 0.65rem;
            letter-spacing: 0.08em;
            color: #c06060;
            margin-top: 0.4rem;
        }

        /* ALERTS */
        .alert {
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
            border-left: 3px solid var(--accent);
            background: rgba(200, 184, 154, 0.05);
            font-family: 'DM Mono', monospace;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
        }

        .alert-error {
            border-left-color: #c06060;
            background: rgba(192, 96, 96, 0.05);
            color: #c09090;
        }

        /* DIVIDER */
        .divider {
            border: none;
            border-top: 1px solid var(--border);
            margin: 2rem 0;
        }

        /* PILL / TAG */
        .tag {
            display: inline-block;
            font-family: 'DM Mono', monospace;
            font-size: 0.6rem;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--muted);
            border: 1px solid var(--border);
            padding: 0.2rem 0.6rem;
        }

        .tag-accent {
            color: var(--accent);
            border-color: var(--accent2);
        }

        /* FOOTER */
        footer {
            border-top: 1px solid var(--border);
            padding: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        footer .mono { color: var(--muted); }

        /* UTIL */
        .flex { display: flex; }
        .items-center { align-items: center; }
        .justify-between { justify-content: space-between; }
        .gap-1 { gap: 0.5rem; }
        .gap-2 { gap: 1rem; }
        .mt-1 { margin-top: 0.5rem; }
        .mt-2 { margin-top: 1rem; }
        .mt-4 { margin-top: 2rem; }
        .mb-2 { margin-bottom: 1rem; }
        .mb-4 { margin-bottom: 2rem; }
        .text-muted { color: var(--muted); }
        .text-accent { color: var(--accent); }
        .text-sm { font-size: 0.85rem; }

        /* SCROLLBAR */
        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-track { background: var(--bg); }
        ::-webkit-scrollbar-thumb { background: var(--border); }

        /* RESPONSIVE */
        @media (max-width: 640px) {
            .nav-links { gap: 1rem; }
            .card-grid { grid-template-columns: 1fr; }
        }
    </style>
    @yield('styles')
</head>
<body>
    <nav>
        <a href="{{ route('home') }}" class="nav-logo">VOID</a>
        <ul class="nav-links">
            <li><a href="{{ route('articles.index') }}">Articles</a></li>
            <li><a href="{{ route('polls.index') }}">Polls</a></li>
            @auth
                @if(auth()->user()->isAdmin())
                    <li><a href="{{ route('admin.dashboard') }}">Admin</a></li>
                @endif
                <li><a href="{{ route('articles.create') }}">+ Write</a></li>
                <li>
                    <form action="{{ route('logout') }}" method="POST" style="display:inline">
                        @csrf
                        <button type="submit" style="background:none;border:none;cursor:pointer;" class="nav-links a">
                            <a href="#" onclick="this.closest('form').submit()">Logout</a>
                        </button>
                    </form>
                </li>
            @else
                <li><a href="{{ route('login') }}">Login</a></li>
                <li><a href="{{ route('register') }}" class="nav-highlight">Join</a></li>
            @endauth
        </ul>
    </nav>

    <main>
        @if(session('success'))
            <div style="max-width:1200px;margin:0 auto;padding:1rem 2rem 0;">
                <div class="alert">{{ session('success') }}</div>
            </div>
        @endif

        @if($errors->any())
            <div style="max-width:1200px;margin:0 auto;padding:1rem 2rem 0;">
                <div class="alert alert-error">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <footer>
        <span class="mono">VOID JOURNAL — {{ date('Y') }}</span>
        <span class="mono">{{ auth()->check() ? auth()->user()->name : 'ANONYMOUS' }}</span>
    </footer>

    @yield('scripts')
</body>
</html>
