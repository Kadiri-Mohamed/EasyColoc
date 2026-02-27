{{-- resources/views/expenses/index.blade.php --}}
@extends('layouts.user')

@section('page-title', 'Depenses - ' . $colocation->name)

@section('content')
<div class="container mx-auto">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-xl font-semibold">Depenses</h2>
            <p class="text-gray-600 text-sm">{{ $colocation->name }}</p>
        </div>
        <a href="{{ route('expenses.create', $colocation) }}" class="btn-primary">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <line x1="12" y1="5" x2="12" y2="19" />
                <line x1="5" y1="12" x2="19" y2="12" />
            </svg>
            Nouvelle depense
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="grid md:grid-cols-4 gap-4 mb-6">
        <div class="card">
            <div class="card-body">
                <p class="text-sm text-gray-500">Total depenses</p>
                <p class="text-2xl font-bold">{{ number_format($stats['total'], 2) }} MAD</p>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <p class="text-sm text-gray-500">En attente</p>
                <p class="text-2xl font-bold text-orange-600">{{ number_format($stats['pending'], 2) }} MAD</p>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <p class="text-sm text-gray-500">Categories</p>
                <p class="text-2xl font-bold">{{ $categories->count() }}</p>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <p class="text-sm text-gray-500">Moyenne/mois</p>
                <p class="text-2xl font-bold">{{ number_format($stats['total'] / 6, 2) }} MAD</p>
            </div>
        </div>
    </div>

    <!-- Filtres -->
    <div class="card mb-6">
        <div class="card-body">
            <form method="GET" class="grid md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm text-gray-600 mb-1">Categorie</label>
                    <select name="category_id" class="w-full border rounded-lg px-3 py-2">
                        <option value="">Toutes</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm text-gray-600 mb-1">Mois</label>
                    <select name="month" class="w-full border rounded-lg px-3 py-2">
                        <option value="">Tous</option>
                        @foreach(range(1, 12) as $month)
                            <option value="{{ $month }}" {{ request('month') == $month ? 'selected' : '' }}>
                                {{ DateTime::createFromFormat('!m', $month)->format('F') }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm text-gray-600 mb-1">Annee</label>
                    <select name="year" class="w-full border rounded-lg px-3 py-2">
                        <option value="">Toutes</option>
                        @foreach(range(date('Y'), date('Y')-2) as $year)
                            <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="btn-primary w-full justify-center">Filtrer</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Liste des depenses -->
    <div class="card">
        <div class="card-body">
            @if($expenses->count() > 0)
                <div class="table-container">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Titre</th>
                                <th>Categorie</th>
                                <th>Paye par</th>
                                <th class="text-right">Montant</th>
                                <th class="text-right">Statut</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($expenses as $expense)
                                <tr>
                                    <td>{{ $expense->expense_date->format('d/m/Y') }}</td>
                                    <td class="font-medium">{{ $expense->title }}</td>
                                    <td>
                                        <span class="badge" style="background: {{ $expense->category->color }}20; color: {{ $expense->category->color }};">
                                            {{ $expense->category->name }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="flex items-center gap-2">
                                            <div class="member-avatar w-6 h-6 text-xs">
                                                {{ strtoupper(substr($expense->payer->name, 0, 1)) }}
                                            </div>
                                            {{ $expense->payer->name }}
                                        </div>
                                    </td>
                                    <td class="text-right font-semibold">{{ number_format($expense->amount, 2) }} MAD</td>
                                    <td class="text-right">
                                        @php
                                            $totalPaid = $expense->payments->where('is_paid', true)->sum('amount');
                                            $progress = $expense->amount > 0 ? ($totalPaid / $expense->amount) * 100 : 0;
                                        @endphp
                                        <div class="flex items-center gap-2">
                                            <div class="w-20 bg-gray-200 rounded-full h-2">
                                                <div class="bg-green-500 h-2 rounded-full" style="width: {{ $progress }}%"></div>
                                            </div>
                                            <span class="text-sm">{{ number_format($totalPaid, 0) }}/{{ number_format($expense->amount, 0) }}</span>
                                        </div>
                                    </td>
                                    <td class="text-right">
                                        <a href="{{ route('expenses.show', [$colocation, $expense]) }}" class="text-orange-500 hover:text-orange-600">
                                            Voir
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $expenses->links() }}
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-state-icon">💰</div>
                    <div class="empty-state-title">Aucune depense</div>
                    <div class="empty-state-text">
                        Commencez par ajouter une première depense pour votre colocation.
                    </div>
                    <a href="{{ route('expenses.create', $colocation) }}" class="btn-primary">
                        Ajouter une depense
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection