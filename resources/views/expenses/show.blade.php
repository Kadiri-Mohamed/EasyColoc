@extends('layouts.user')

@section('page-title', $expense->title . ' - ' . $colocation->name)

@section('content')
    <div class="container mx-auto max-w-4xl">
        <div class="mb-6 flex justify-between items-center">
            <a href="{{ route('colocation.show', $colocation) }}"
                class="text-orange-500 hover:text-orange-600 flex items-center gap-1">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="19" y1="12" x2="5" y2="12" />
                    <polyline points="12 19 5 12 12 5" />
                </svg>
                Retour a la colocation
            </a>

            <div class="flex gap-2">
                @if(auth()->id() === $expense->payer_id)
                    <form action="{{ route('expenses.destroy', [$colocation, $expense]) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-danger" onclick="return confirm('Supprimer cette depense ?')">
                            Supprimer
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            <!-- Informations principales -->
            <div class="md:col-span-2">
                <div class="card mb-6">
                    <div class="card-header">
                        <div class="card-title">
                            <span>💰</span>
                            {{ $expense->title }}
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="grid md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <p class="text-sm text-gray-500">Montant</p>
                                <p class="text-3xl font-bold text-orange-600">{{ number_format($expense->amount, 2) }} MAD
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Date</p>
                                <p class="text-lg">{{ $expense->expense_date }}</p>
                            </div>
                        </div>

                        <div class="mb-4">
                            <p class="text-sm text-gray-500">Paye par</p>
                            <div class="flex items-center gap-2 mt-1">
                                <div class="member-avatar w-8 h-8">
                                    {{ strtoupper(substr($expense->payer->name, 0, 1)) }}
                                </div>
                                <span class="font-medium">{{ $expense->payer->name }}</span>
                            </div>
                        </div>

                        <div class="mb-4">
                            <p class="text-sm text-gray-500">Categorie</p>
                            <span class="badge mt-1"
                                style="background: {{ $expense->category->color }}20; color: {{ $expense->category->color }};">
                                {{ $expense->category->name }}
                            </span>
                        </div>

                        @if($expense->description)
                            <div class="mb-4">
                                <p class="text-sm text-gray-500">Description</p>
                                <p class="mt-1">{{ $expense->description }}</p>
                            </div>
                        @endif

                        @if($expense->notes)
                            <div>
                                <p class="text-sm text-gray-500">Notes</p>
                                <p class="mt-1 text-gray-600">{{ $expense->notes }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Paiements -->
            <div>
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <span>💸</span>
                            Paiements
                        </div>
                    </div>
                    <div class="card-body">
                        <p class="text-sm text-gray-500 mb-4">
                            Part par membre:
                            <span
                                class="font-semibold">{{ number_format($expense->amount / ($expense->payments->count() + 1), 2) }}
                                MAD</span>
                        </p>

                        <div class="space-y-3">
                            <!-- Le payeur a deja paye (logique) -->
                            <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg">
                                <div class="flex items-center gap-2">
                                    <div class="member-avatar w-8 h-8">
                                        {{ strtoupper(substr($expense->payer->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="font-medium">{{ $expense->payer->name }}</p>
                                        <p class="text-xs text-green-600">Paye (avance)</p>
                                    </div>
                                </div>
                                <span
                                    class="font-semibold text-green-600">{{ number_format($expense->amount / ($expense->payments->count() + 1), 2) }}
                                    MAD</span>
                            </div>

                            <!-- Les autres membres -->
                            @foreach($expense->payments as $payment)
                                <div
                                    class="flex items-center justify-between p-3 {{ $payment->is_paid ? 'bg-green-50' : 'bg-orange-50' }} rounded-lg">
                                    <div class="flex items-center gap-2">
                                        <div class="member-avatar w-8 h-8">
                                            {{ strtoupper(substr($payment->user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="font-medium">{{ $payment->user->name }}</p>
                                            <p class="text-xs {{ $payment->is_paid ? 'text-green-600' : 'text-orange-600' }}">
                                                {{ $payment->is_paid ? 'Paye le ' . $payment->paid_at : 'En attente' }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <span class="font-semibold">{{ number_format($payment->amount, 2) }} MAD</span>
                                        @if(!$payment->is_paid && auth()->id() === $expense->payer_id)
                                            <form action="{{ route('payments.mark-paid', [$colocation, $payment]) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="text-sm text-green-600 hover:text-green-700">
                                                    Marquer paye
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection