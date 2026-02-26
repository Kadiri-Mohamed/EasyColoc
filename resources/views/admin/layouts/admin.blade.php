<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — EasyColoc</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background: #f8f9fa;
            color: #1f2937;
        }

        /* ── SIDEBAR ── */
        .admin-layout {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 260px;
            min-height: 100vh;
            background: linear-gradient(180deg, #1f2937 0%, #111827 100%);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            z-index: 50;
        }

        .sidebar-brand {
            padding: 1.5rem 1.5rem 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            display: flex;
            align-items: center;
            gap: 0.65rem;
        }

        .sidebar-brand img {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: rgba(226, 161, 111, 0.15);
            padding: 4px;
        }

        .sidebar-brand span {
            font-size: 1.2rem;
            font-weight: 700;
            color: #E2A16F;
        }

        .sidebar-badge {
            font-size: 0.65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            background: #E2A16F;
            color: #fff;
            padding: 2px 8px;
            border-radius: 50px;
            margin-left: auto;
        }

        .sidebar-section-title {
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: rgba(255, 255, 255, 0.3);
            padding: 1.2rem 1.5rem 0.4rem;
        }

        .sidebar-nav {
            flex: 1;
            padding: 0.5rem 0.75rem;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.7rem 0.9rem;
            border-radius: 10px;
            text-decoration: none;
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.9rem;
            font-weight: 500;
            transition: background 0.15s, color 0.15s;
            margin-bottom: 2px;
        }

        .sidebar-link:hover {
            background: rgba(255, 255, 255, 0.06);
            color: rgba(255, 255, 255, 0.9);
        }

        .sidebar-link.active {
            background: rgba(226, 161, 111, 0.18);
            color: #E2A16F;
        }

        .sidebar-link svg {
            width: 18px;
            height: 18px;
            flex-shrink: 0;
        }

        .sidebar-footer {
            padding: 1rem 1.5rem;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
        }

        .sidebar-user {
            display: flex;
            align-items: center;
            gap: 0.65rem;
        }

        .sidebar-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, #E2A16F, #c8834d);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.95rem;
            font-weight: 700;
            color: #fff;
            flex-shrink: 0;
        }

        .sidebar-user-name {
            font-size: 0.88rem;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.8);
        }

        .sidebar-user-role {
            font-size: 0.75rem;
            color: rgba(255, 255, 255, 0.4);
        }

        /* ── MAIN CONTENT ── */
        .admin-main {
            margin-left: 260px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .admin-topbar {
            background: #fff;
            border-bottom: 1px solid #D1D3D4;
            padding: 0 2rem;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 40;
        }

        .admin-topbar h1 {
            font-size: 1.15rem;
            font-weight: 700;
            color: #1f2937;
        }

        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .admin-content {
            padding: 2rem;
            flex: 1;
        }

        /* ── FLASH MESSAGES ── */
        .flash {
            padding: 0.85rem 1.2rem;
            border-radius: 12px;
            font-size: 0.9rem;
            font-weight: 500;
            margin-bottom: 1.5rem;
        }

        .flash-success {
            background: #f0fdf4;
            border: 1px solid #86efac;
            color: #16a34a;
        }

        .flash-error {
            background: #fef2f2;
            border: 1px solid #fca5a5;
            color: #dc2626;
        }

        .flash-info {
            background: #eff6ff;
            border: 1px solid #93c5fd;
            color: #2563eb;
        }
    </style>
    @stack('styles')
</head>

<body>
    <div class="admin-layout">

        <!-- ── SIDEBAR ── -->
        <aside class="sidebar">
            <div class="sidebar-brand">
                <img src="{{ asset('logo.png') }}" alt="Logo">
                <span>EasyColoc</span>
            </div>

            <nav class="sidebar-nav">
                <p class="sidebar-section-title">Navigation</p>

                <a href="{{ route('admin.dashboard') }}"
                    class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="3" width="7" height="7" />
                        <rect x="14" y="3" width="7" height="7" />
                        <rect x="14" y="14" width="7" height="7" />
                        <rect x="3" y="14" width="7" height="7" />
                    </svg>
                    Dashboard
                </a>


                <p class="sidebar-section-title">Accès rapide</p>

                <a href="{{ route('dashboard') }}" class="sidebar-link">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                        <polyline points="9 22 9 12 15 12 15 22" />
                    </svg>
                    Retour au site
                </a>
            </nav>
        </aside>

        <!-- ── MAIN ── -->
        <main class="admin-main">
            <!-- Topbar -->
            <div class="admin-topbar">
                <h1>@yield('page-title', 'Administration')</h1>
                <div class="topbar-actions">
                    <!-- User info -->
                    <div class="sidebar-footer">
                        <div class="sidebar-user">
                            <div>
                                <div>{{ auth()->user()->name }}</div>
                            </div>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                        @csrf
                        <button type="submit" style="
                        background: #fef2f2;
                        border: 1px solid #fca5a5;
                        color: #dc2626;
                        padding: 0.4rem 0.9rem;
                        border-radius: 8px;
                        font-size: 0.85rem;
                        font-weight: 600;
                        cursor: pointer;
                    ">Logout</button>
                    </form>
                </div>
            </div>

            <!-- Content -->
            <div class="admin-content">
                {{-- Flash messages --}}
                @if(session('success'))
                    <div class="flash flash-success">✓ {{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="flash flash-error">✕ {{ session('error') }}</div>
                @endif
                @if(session('info'))
                    <div class="flash flash-info">ℹ {{ session('info') }}</div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    @stack('scripts')
</body>

</html>