@extends('layouts.user')

@section('page-title', 'Tableau de bord')

@section('content')
    <div class="container mx-auto">
        <!-- Welcome Banner -->
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
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
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
                    <div class="stat-value">{{ $user->reputation }}</div>
                    <div class="stat-label">Reputation</div>
                    <div class="stat-sub">Total de vos paiements</div>
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

        </div>

        <!-- Recent Expenses -->
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <span>💳</span>
                    Mes dépenses récentes
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
                                    {{ $expense->category?->name ?? 'Sans catégorie' }}
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
                        <div class="empty-state-title">Aucune dépense</div>
                        <div class="empty-state-text">Vous n'avez pas encore payé de dépenses.</div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection