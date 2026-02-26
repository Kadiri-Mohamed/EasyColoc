<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Mon Tableau de bord — EasyColoc</title>

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

        /* ── FLASH ── */
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

        /* ── WELCOME BANNER ── */
        .welcome-banner {
            background: linear-gradient(135deg, #1a2744 0%, #253563 50%, #1a2744 100%);
            border-radius: 20px;
            padding: 2rem 2.5rem;
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1.5rem;
            position: relative;
            overflow: hidden;
        }

        .welcome-banner::before {
            content: '';
            position: absolute;
            top: -60px;
            right: -60px;
            width: 220px;
            height: 220px;
            background: rgba(226, 161, 111, 0.08);
            border-radius: 50%;
        }

        .welcome-banner::after {
            content: '';
            position: absolute;
            bottom: -80px;
            right: 120px;
            width: 180px;
            height: 180px;
            background: rgba(226, 161, 111, 0.05);
            border-radius: 50%;
        }

        .welcome-title {
            font-size: 1.5rem;
            font-weight: 800;
            color: #fff;
            margin-bottom: 0.3rem;
        }

        .welcome-sub {
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.5);
        }

        .welcome-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            background: rgba(226, 161, 111, 0.15);
            border: 1px solid rgba(226, 161, 111, 0.3);
            color: #E2A16F;
            padding: 0.4rem 0.9rem;
            border-radius: 50px;
            font-size: 0.82rem;
            font-weight: 600;
            margin-top: 0.75rem;
        }

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
            position: relative;
            z-index: 1;
        }

        .btn-primary:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }

        /* ── STATS GRID ── */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.25rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 16px;
            padding: 1.5rem;
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            transition: box-shadow 0.2s, transform 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.07);
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            flex-shrink: 0;
        }

        .stat-value {
            font-size: 1.9rem;
            font-weight: 800;
            line-height: 1;
            color: #1f2937;
        }

        .stat-label {
            font-size: 0.82rem;
            color: #9ca3af;
            font-weight: 500;
            margin-top: 0.3rem;
        }

        .stat-sub {
            font-size: 0.78rem;
            color: #6b7280;
            margin-top: 0.4rem;
        }

        /* ── REPUTATION ── */
        .reputation-bar-wrap {
            background: #f3f4f6;
            border-radius: 50px;
            height: 8px;
            overflow: hidden;
            margin-top: 0.5rem;
            width: 100%;
        }

        .reputation-bar-fill {
            height: 100%;
            border-radius: 50px;
            background: linear-gradient(90deg, #E2A16F, #c8834d);
            transition: width 0.8s ease;
        }

        /* ── CONTENT GRID ── */
        .content-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        @media (max-width: 900px) {
            .content-grid {
                grid-template-columns: 1fr;
            }
        }

        /* ── CARDS ── */
        .user-card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 16px;
            overflow: hidden;
        }

        .user-card-full {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 16px;
            overflow: hidden;
            margin-bottom: 1.5rem;
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

        /* ── EXPENSE ITEMS ── */
        .expense-list {
            padding: 0.5rem 0;
        }

        .expense-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.85rem 1.5rem;
            border-bottom: 1px solid #f9fafb;
            transition: background 0.1s;
        }

        .expense-item:last-child {
            border-bottom: none;
        }

        .expense-item:hover {
            background: #fafafa;
        }

        .expense-left {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .expense-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: #FFF0DD;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            flex-shrink: 0;
        }

        .expense-title {
            font-size: 0.9rem;
            font-weight: 600;
            color: #1f2937;
        }

        .expense-date {
            font-size: 0.78rem;
            color: #9ca3af;
            margin-top: 2px;
        }

        .expense-amount {
            font-size: 1rem;
            font-weight: 700;
            color: #E2A16F;
        }

        /* ── COLOCATION CARD ── */
        .coloc-members {
            display: flex;
            gap: 0.4rem;
            flex-wrap: wrap;
            padding: 1rem 1.5rem;
        }

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

        /* ── BADGE ── */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 3px 10px;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .badge-active {
            background: #f0fdf4;
            color: #16a34a;
        }

        .badge-admin {
            background: rgba(226, 161, 111, 0.15);
            color: #E2A16F;
        }

        /* ── NO COLOCATION BANNER ── */
        .no-coloc-banner {
            background: linear-gradient(135deg, #fffbf5 0%, #fff8ef 100%);
            border: 1px dashed #E2A16F;
            border-radius: 16px;
            padding: 2rem;
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .no-coloc-banner h3 {
            font-size: 1.1rem;
            font-weight: 700;
            color: #92400e;
            margin-bottom: 0.4rem;
        }

        .no-coloc-banner p {
            font-size: 0.88rem;
            color: #b45309;
            margin-bottom: 1.25rem;
        }
    </style>
</head>

<body>
    <div class="user-layout">

        <!-- ── SIDEBAR ── -->
        <aside class="sidebar">
             <div class="sidebar-brand">
                <img src="{{ asset('logo.png') }}" alt="Logo">
                <span>EasyColoc</span>
            </div>

            <nav class="sidebar-nav">
                <p class="sidebar-section-title">Navigation</p>

                <a href="{{ route('dashboard') }}" class="sidebar-link active">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="3" width="7" height="7" />
                        <rect x="14" y="3" width="7" height="7" />
                        <rect x="14" y="14" width="7" height="7" />
                        <rect x="3" y="14" width="7" height="7" />
                    </svg>
                    Tableau de bord
                </a>

                <a href="{{ route('profile') }}" class="sidebar-link">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                        <circle cx="12" cy="7" r="4" />
                    </svg>
                    Mon Profil
                </a>

                @if(!$activeColocation)
                    <p class="sidebar-section-title">Colocations</p>
                    <a href="#" class="sidebar-link" id="btn-create-coloc-sidebar">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="12" y1="5" x2="12" y2="19" />
                            <line x1="5" y1="12" x2="19" y2="12" />
                        </svg>
                        Creer une colocation
                    </a>
                @else
                    <p class="sidebar-section-title">Ma Colocation</p>
                    <a href="#" class="sidebar-link">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                            <polyline points="9 22 9 12 15 12 15 22" />
                        </svg>
                        {{ $activeColocation->name }}
                    </a>
                @endif

                @if(auth()->user()->is_admin)
                    <p class="sidebar-section-title">Administration</p>
                    <a href="{{ route('admin.dashboard') }}" class="sidebar-link admin-link">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path
                                d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                        </svg>
                        Admin Dashboard
                    </a>
                @endif
            </nav>

            <div class="sidebar-footer">
                <div class="sidebar-user">
                    <div style="min-width:0;">
                        <div class="sidebar-user-name">{{ auth()->user()->name }}</div>
                        <div class="sidebar-user-role">
                            {{ auth()->user()->is_admin ? 'Administrateur' : 'Membre' }}
                        </div>
                    </div>
                </div>
            </div>
        </aside>

        <!-- ── MAIN ── -->
        <main class="user-main">
            <!-- Topbar -->
            <div class="user-topbar">
                <h1>Mon Espace</h1>
                <div class="topbar-right">
                    <span class="topbar-greeting">
                        Bonjour, <strong>{{ auth()->user()->name }}</strong>
                    </span>
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
            <div class="user-content">

                {{-- Flash messages --}}
                @if(session('success'))
                    <div class="flash flash-success">✓ {{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="flash flash-error">✕ {{ session('error') }}</div>
                @endif

                <div class="welcome-banner">
                    <div>
                        <div class="welcome-title">
                            Bienvenue, {{ auth()->user()->name }} !
                        </div>
                        <div class="welcome-sub">
                            @if($activeColocation)
                                Vous faites partie de
                                <strong style="color:#E2A16F;">{{ $activeColocation->name }}</strong>
                            @else
                                Vous n'avez pas encore de colocation active.
                            @endif
                        </div>
                    </div>
                    @if(!$activeColocation)
                        <a href="#create-coloc-section" class="btn-primary">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.5">
                                <line x1="12" y1="5" x2="12" y2="19" />
                                <line x1="5" y1="12" x2="19" y2="12" />
                            </svg>
                            Creer une colocation
                        </a>
                    @endif
                </div>

                {{-- ── STATS CARDS ── --}}
                <div class="stats-grid">

                    {{-- Reputation --}}
                    <div class="stat-card">
                        <div class="stat-icon" style="background:#FFF0DD; color:#E2A16F;">⭐</div>
                        <div style="flex:1; min-width:0;">
                            <div class="stat-value">{{ $reputationPercent }}</div>
                            <div class="stat-label">Reputation</div>
                            <div class="reputation-bar-wrap">
                                <div class="reputation-bar-fill" style="width: {{ $reputationPercent }}%"></div>
                            </div>
                        </div>
                    </div>

                    {{-- Total depenses payees --}}
                    <div class="stat-card">
                        <div class="stat-icon" style="background:#f0fdf4; color:#16a34a;">💰</div>
                        <div>
                            <div class="stat-value">{{ number_format($totalPaid, 2) }}</div>
                            <div class="stat-label">Depenses payees (MAD)</div>
                            <div class="stat-sub">Total de vos paiements</div>
                        </div>
                    </div>

                    {{-- Colocation --}}
                    <div class="stat-card">
                        <div class="stat-icon" style="background:#eff6ff; color:#3b82f6;">🏠</div>
                        <div>
                            <div class="stat-value" style="font-size:1.3rem;">
                                @if($activeColocation)
                                    {{ $activeColocation->name }}
                                @else
                                    —
                                @endif
                            </div>
                            <div class="stat-label">Ma colocation</div>
                            <div class="stat-sub">
                                @if($activeColocation)
                                    {{ $activeColocation->members->count() }} membre(s)
                                @else
                                    Aucune colocation active
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Depenses colocation --}}
                    @if($activeColocation)
                        <div class="stat-card">
                            <div class="stat-icon" style="background:#fdf4ff; color:#a855f7;">📊</div>
                            <div>
                                <div class="stat-value">{{ number_format($totalColocationExpenses, 2) }}</div>
                                <div class="stat-label">Depenses colocation (MAD)</div>
                                <div class="stat-sub">Total de la colocation</div>
                            </div>
                        </div>
                    @endif

                </div>

                <div>
                    {{-- Recent Expenses --}}
                    <div class="user-card">
                        <div class="card-header">
                            <div class="card-title">
                                💳 Mes depenses recentes
                            </div>
                        </div>
                        <div class="expense-list">
                            @forelse($recentExpenses as $expense)
                                <div class="expense-item">
                                    <div class="expense-left">
                                        <div class="expense-icon">
                                            {{ $expense->category ? '🏷' : '💸' }}
                                        </div>
                                        <div>
                                            <div class="expense-title">{{ $expense->title }}</div>
                                            <div class="expense-date">
                                                {{ $expense->category?->name ?? 'Sans categorie' }}
                                                &nbsp;·&nbsp;
                                                {{ \Carbon\Carbon::parse($expense->expense_date)->format('d M Y') }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="expense-amount">{{ number_format($expense->amount, 2) }} MAD</div>
                                </div>
                            @empty
                                <div class="empty-state">
                                    <div class="empty-state-icon">📭</div>
                                    <div class="empty-state-title">Aucune depense</div>
                                    <div class="empty-state-text">Vous n'avez pas encore paye de depenses.</div>
                                </div>
                            @endforelse
                        </div>
                    </div>

                </div>

            </div>
        </main>
    </div>
</body>

</html>