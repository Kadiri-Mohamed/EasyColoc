{{-- resources/views/colocation/show.blade.php --}}
@extends('layouts.user')

@section('page-title', $colocation->name)

@section('content')
<div class="container mx-auto">
    <!-- Header avec actions -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <span class="badge {{ $colocation->status === 'active' ? 'badge-success' : 'badge-danger' }} mb-2">
                {{ $colocation->status === 'active' ? 'Active' : 'Annulee' }}
            </span>
            <h2 class="text-xl font-semibold">{{ $colocation->name }}</h2>
            @if($colocation->description)
                <p class="text-gray-600 text-sm mt-1">{{ $colocation->description }}</p>
            @endif
        </div>
        
        <div class="flex gap-2">
            @if(auth()->user()->memberships->where('colocation_id', $colocation->id)->first()?->membership_role === 'owner')
                <a href="" class="btn-primary">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                        <circle cx="8.5" cy="7" r="4" />
                        <line x1="20" y1="8" x2="20" y2="14" />
                        <line x1="23" y1="11" x2="17" y2="11" />
                    </svg>
                    Inviter
                </a>
                <form action="" method="POST" class="inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn-danger" 
                            onclick="return confirm('Êtes-vous sûr de vouloir annuler cette colocation ?')">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M18 6L6 18" />
                            <path d="M6 6l12 12" />
                        </svg>
                        Annuler
                    </button>
                </form>
            @else
                <form action="{{ route('colocation.leave', $colocation) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-danger"
                            onclick="return confirm('Êtes-vous sûr de vouloir quitter cette colocation ?')">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                            <polyline points="16 17 21 12 16 7" />
                            <line x1="21" y1="12" x2="9" y2="12" />
                        </svg>
                        Quitter
                    </button>
                </form>
            @endif
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid md:grid-cols-3 gap-6 mb-8">
        <div class="card">
            <div class="card-body flex items-center gap-4">
                <div class="stat-icon" style="background:#eff6ff; color:#3b82f6;">👥</div>
                <div>
                    <div class="text-2xl font-bold">{{ $memberCount }}</div>
                    <div class="text-sm text-gray-500">Membres</div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body flex items-center gap-4">
                <div class="stat-icon" style="background:#f0fdf4; color:#16a34a;">💰</div>
                <div>
                    <div class="text-2xl font-bold">{{ number_format($totalExpenses, 2) }} MAD</div>
                    <div class="text-sm text-gray-500">Total depenses</div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body flex items-center gap-4">
                <div class="stat-icon" style="background:#fffbeb; color:#d97706;">📅</div>
                <div>
                    <div class="text-2xl font-bold">{{ $colocation->created_at }}</div>
                    <div class="text-sm text-gray-500">Creee le</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Membres -->
    <div class="card mb-8">
        <div class="card-header">
            <div class="card-title">
                <span>👥</span>
                Membres
            </div>
            <span class="text-sm text-gray-500">{{ $memberCount }} membre(s)</span>
        </div>
        <div class="card-body">
            <div class="space-y-4">
                @foreach($colocation->memberships as $membership)
                    <div class="flex items-center justify-between py-2 border-b last:border-0">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-orange-100 flex items-center justify-center text-orange-600 font-semibold">
                                {{ strtoupper(substr($membership->user->name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-medium">{{ $membership->user->name }}</p>
                                <div class="flex gap-2 mt-1">
                                    <span class="badge {{ $membership->membership_role === 'owner' ? 'badge-owner' : 'badge-info' }}">
                                        {{ $membership->membership_role === 'owner' ? 'Owner' : 'Membre' }}
                                    </span>
                                    <span class="badge badge-success">Membre depuis {{ $membership->joined_at }}</span>
                                </div>
                            </div>
                        </div>
                        
                        @if(auth()->user()->memberships->where('colocation_id', $colocation->id)->first()?->membership_role === 'owner' 
                            && auth()->id() !== $membership->user_id)
                            <form action="" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-danger text-sm py-1 px-3"
                                        onclick="return confirm('Retirer ce membre ?')">
                                    Retirer
                                </button>
                            </form>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Depenses recentes -->
    <div class="card mb-8">
        <div class="card-header">
            <div class="card-title">
                <span>💳</span>
                Depenses recentes
            </div>
            <a href="" class="btn-primary text-sm py-1.5 px-3">
                + Nouvelle depense
            </a>
        </div>
        <div class="card-body">
            @if($colocation->expenses->count() > 0)
                <div class="table-container">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Titre</th>
                                <th>Paye par</th>
                                <th>Categorie</th>
                                <th class="text-right">Montant</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($colocation->expenses as $expense)
                                <tr>
                                    <td>{{ $expense->expense_date->format('d/m/Y') }}</td>
                                    <td class="font-medium">{{ $expense->title }}</td>
                                    <td>
                                        <div class="flex items-center gap-2">
                                            <div class="member-avatar w-6 h-6 text-xs">
                                                {{ strtoupper(substr($expense->payer->name, 0, 1)) }}
                                            </div>
                                            {{ $expense->payer->name }}
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge" style="background: {{ $expense->category->color }}20; color: {{ $expense->category->color }};">
                                            {{ $expense->category->name }}
                                        </span>
                                    </td>
                                    <td class="text-right font-semibold text-orange-600">
                                        {{ number_format($expense->amount, 2) }} MAD
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-state-icon">💰</div>
                    <div class="empty-state-title">Aucune depense</div>
                    <div class="empty-state-text">
                        Commencez par ajouter une première depense pour votre colocation.
                    </div>
                    <a href="" class="btn-primary">
                        Ajouter une depense
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Soldes -->
    @if(isset($balances) && count($balances) > 0)
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <span>⚖️</span>
                    Soldes
                </div>
            </div>
            <div class="card-body">
                <div class="grid md:grid-cols-2 gap-4">
                    @foreach($balances as $balance)
                        <div class="border rounded-lg p-4 {{ $balance['balance'] >= 0 ? 'bg-green-50' : 'bg-red-50' }}">
                            <div class="flex justify-between items-start mb-2">
                                <div class="flex items-center gap-2">
                                    <div class="member-avatar w-8 h-8">
                                        {{ strtoupper(substr($balance['user']->name, 0, 1)) }}
                                    </div>
                                    <span class="font-medium">{{ $balance['user']->name }}</span>
                                </div>
                                <span class="text-xl font-bold {{ $balance['balance'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ number_format($balance['balance'], 2) }} MAD
                                </span>
                            </div>
                            <div class="grid grid-cols-2 gap-2 text-sm mt-3">
                                <div>
                                    <span class="text-gray-500">A paye:</span>
                                    <span class="font-medium block">{{ number_format($balance['paid'], 2) }} MAD</span>
                                </div>
                                <div>
                                    <span class="text-gray-500">Doit:</span>
                                    <span class="font-medium block">{{ number_format($balance['owed'], 2) }} MAD</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>
@endsection