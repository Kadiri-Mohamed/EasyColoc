<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'EasyColoc') — EasyColoc</title>

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

        /* ── LAYOUT ── */
        .user-layout {
            display: flex;
            min-height: 100vh;
        }

        /* ── SIDEBAR ── */
        .sidebar {
            width: 260px;
            min-height: 100vh;
            background: linear-gradient(180deg, #1a2744 0%, #0f1729 100%);
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

        .sidebar-section-title {
            font-size: 0.68rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: rgba(255, 255, 255, 0.28);
            padding: 1.2rem 1.5rem 0.4rem;
        }

        .sidebar-nav {
            flex: 1;
            padding: 0.5rem 0.75rem;
            overflow-y: auto;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.7rem 0.9rem;
            border-radius: 10px;
            text-decoration: none;
            color: rgba(255, 255, 255, 0.55);
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

        .sidebar-link.admin-link {
            background: rgba(226, 161, 111, 0.1);
            color: #E2A16F;
            border: 1px solid rgba(226, 161, 111, 0.25);
        }

        .sidebar-link.admin-link:hover {
            background: rgba(226, 161, 111, 0.22);
            color: #f5b880;
        }

        .sidebar-link svg {
            width: 18px;
            height: 18px;
            flex-shrink: 0;
        }

        .sidebar-footer {
            padding: 1rem 1.25rem;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
        }

        .sidebar-user {
            display: flex;
            align-items: center;
            gap: 0.65rem;
        }

        .sidebar-avatar {
            width: 38px;
            height: 38px;
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
            color: rgba(255, 255, 255, 0.85);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .sidebar-user-role {
            font-size: 0.73rem;
            color: rgba(255, 255, 255, 0.38);
        }

        /* ── MAIN ── */
        .user-main {
            margin-left: 260px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .user-topbar {
            background: #fff;
            border-bottom: 1px solid #e5e7eb;
            padding: 0 2rem;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 40;
        }

        .user-topbar h1 {
            font-size: 1.15rem;
            font-weight: 700;
            color: #1f2937;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .topbar-greeting {
            font-size: 0.88rem;
            color: #6b7280;
            font-weight: 500;
        }

        .btn-logout {
            background: #fef2f2;
            border: 1px solid #fca5a5;
            color: #dc2626;
            padding: 0.4rem 0.9rem;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            font-family: inherit;
            text-decoration: none;
            transition: background 0.15s;
        }

        .btn-logout:hover {
            background: #fee2e2;
        }

        .user-content {
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

        /* ── CARDS ── */
        .card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 16px;
            overflow: hidden;
            transition: box-shadow 0.2s, transform 0.2s;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.07);
        }

        .card-header {
            padding: 1.1rem 1.5rem;
            border-bottom: 1px solid #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .card-title {
            font-size: 1rem;
            font-weight: 700;
            color: #1f2937;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .card-body {
            padding: 1.5rem;
        }

        /* ── BUTTONS ── */
        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: linear-gradient(135deg, #E2A16F, #c8834d);
            color: #fff;
            padding: 0.7rem 1.4rem;
            border-radius: 12px;
            font-size: 0.9rem;
            font-weight: 700;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-family: inherit;
            transition: opacity 0.15s, transform 0.15s;
            white-space: nowrap;
        }

        .btn-primary:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }

        .btn-secondary {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: #f3f4f6;
            color: #374151;
            padding: 0.7rem 1.4rem;
            border-radius: 12px;
            font-size: 0.9rem;
            font-weight: 600;
            text-decoration: none;
            border: 1px solid #e5e7eb;
            cursor: pointer;
            transition: background 0.15s;
        }

        .btn-secondary:hover {
            background: #e5e7eb;
        }

        .btn-danger {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: #fef2f2;
            border: 1px solid #fca5a5;
            color: #dc2626;
            padding: 0.7rem 1.4rem;
            border-radius: 12px;
            font-size: 0.9rem;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: background 0.15s;
        }

        .btn-danger:hover {
            background: #fee2e2;
        }

        /* ── BADGES ── */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 3px 10px;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .badge-success {
            background: #f0fdf4;
            color: #16a34a;
        }

        .badge-warning {
            background: #fffbeb;
            color: #d97706;
        }

        .badge-danger {
            background: #fef2f2;
            color: #dc2626;
        }

        .badge-info {
            background: #eff6ff;
            color: #3b82f6;
        }

        .badge-owner {
            background: rgba(226, 161, 111, 0.15);
            color: #E2A16F;
        }

        /* ── TABLES ── */
        .table-container {
            overflow-x: auto;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th {
            text-align: left;
            padding: 0.75rem 1rem;
            background: #f9fafb;
            font-size: 0.85rem;
            font-weight: 600;
            color: #6b7280;
            border-bottom: 1px solid #e5e7eb;
        }

        .table td {
            padding: 0.75rem 1rem;
            border-bottom: 1px solid #f3f4f6;
            color: #1f2937;
        }

        .table tr:last-child td {
            border-bottom: none;
        }

        .table tr:hover td {
            background: #fafafa;
        }

        /* ── MEMBER CHIPS ── */
        .member-chip {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 50px;
            padding: 0.35rem 0.75rem;
            font-size: 0.82rem;
            font-weight: 500;
            color: #374151;
        }

        .member-avatar {
            width: 22px;
            height: 22px;
            border-radius: 50%;
            background: linear-gradient(135deg, #E2A16F, #c8834d);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.6rem;
            font-weight: 700;
            color: #fff;
        }

        /* ── EMPTY STATE ── */
        .empty-state {
            padding: 3rem 1.5rem;
            text-align: center;
        }

        .empty-state-icon {
            font-size: 2.5rem;
            margin-bottom: 0.75rem;
        }

        .empty-state-title {
            font-size: 1rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 0.4rem;
        }

        .empty-state-text {
            font-size: 0.88rem;
            color: #9ca3af;
            margin-bottom: 1.25rem;
        }

        /* ── GRID ── */
        .grid-cols {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
        }
    </style>
</head>

<body>
    <div class="user-layout">
        <!-- SIDEBAR -->
        <aside class="sidebar">
            <div class="sidebar-brand">
                <img src="{{ asset('logo.png') }}" alt="Logo">
                <span>EasyColoc</span>
            </div>

            <nav class="sidebar-nav">
                <p class="sidebar-section-title">Navigation</p>

                <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="3" width="7" height="7" />
                        <rect x="14" y="3" width="7" height="7" />
                        <rect x="14" y="14" width="7" height="7" />
                        <rect x="3" y="14" width="7" height="7" />
                    </svg>
                    Tableau de bord
                </a>

                <a href="" class="sidebar-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                        <circle cx="12" cy="7" r="4" />
                    </svg>
                    Mon Profil
                </a>

                @php
                    $activeColocation = auth()->user()->colocations()->wherePivotNull('left_at')->first();
                @endphp

                @if(!$activeColocation)
                    <p class="sidebar-section-title">Colocations</p>
                    <a href="{{ route('colocation.create') }}" class="sidebar-link">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="12" y1="5" x2="12" y2="19" />
                            <line x1="5" y1="12" x2="19" y2="12" />
                        </svg>
                        Creer une colocation
                    </a>
                @else
                    <p class="sidebar-section-title">Ma Colocation</p>
                    <a href="{{ route('colocation.show', $activeColocation) }}" class="sidebar-link {{ request()->routeIs('colocation.show') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                            <polyline points="9 22 9 12 15 12 15 22" />
                        </svg>
                        {{ $activeColocation->name }}
                    </a>
                    
                @endif
                <a href="{{ route('colocation.index') }}" class="sidebar-link {{ request()->routeIs('colocation.index') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="2" y="2" width="20" height="20" rx="2" />
                            <line x1="8" y1="2" x2="8" y2="22" />
                            <line x1="16" y1="2" x2="16" y2="22" />
                        </svg>
                        Toutes mes colocations
                    </a>

                @if(auth()->user()->is_admin)
                    <p class="sidebar-section-title">Administration</p>
                    <a href="{{ route('admin.dashboard') }}" class="sidebar-link admin-link">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                        </svg>
                        Admin Dashboard
                    </a>
                @endif
            </nav>

            <div class="sidebar-footer">
                <div class="sidebar-user">
                    <div class="sidebar-avatar">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div style="min-width:0;">
                        <div class="sidebar-user-name">{{ auth()->user()->name }}</div>
                        <div class="sidebar-user-role">
                            {{ auth()->user()->is_admin ? 'Administrateur' : 'Membre' }}
                        </div>
                    </div>
                </div>
            </div>
        </aside>

        <!-- MAIN CONTENT -->
        <main class="user-main">
            <!-- Topbar -->
            <div class="user-topbar">
                <h1>@yield('page-title', 'Mon Espace')</h1>
                <div class="topbar-right">
                    <span class="topbar-greeting">
                        Bonjour, <strong>{{ auth()->user()->name }}</strong>
                    </span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn-logout">Logout</button>
                    </form>
                </div>
            </div>

            <!-- Content -->
            <div class="user-content">
                @if(session('success'))
                    <div class="flash flash-success">✓ {{ session('success') }}</div>
                @endif
                
                @if(session('error'))
                    <div class="flash flash-error">✕ {{ session('error') }}</div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>