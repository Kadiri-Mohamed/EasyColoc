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
                <!-- Bouton pour ouvrir le modal -->
                <button type="button" onclick="openInviteModal()" class="btn-primary">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                        <circle cx="8.5" cy="7" r="4" />
                        <line x1="20" y1="8" x2="20" y2="14" />
                        <line x1="23" y1="11" x2="17" y2="11" />
                    </svg>
                    Inviter
                </button>
                
                <form action="{{ route('colocation.cancel', $colocation) }}" method="POST" class="inline">
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

    <!-- MODAL D'INVITATION -->
    <div id="inviteModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden items-center justify-center z-50" style="display: none;">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4">
            <!-- En-tête du modal -->
            <div class="flex justify-between items-center p-6 border-b">
                <h3 class="text-lg font-semibold text-gray-900">Inviter un membre</h3>
                <button onclick="closeInviteModal()" class="text-gray-400 hover:text-gray-600">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="18" y1="6" x2="6" y2="18" />
                        <line x1="6" y1="6" x2="18" y2="18" />
                    </svg>
                </button>
            </div>

            <!-- Corps du modal -->
            <div class="p-6">
                <form id="inviteForm" action="{{ route('invitations.store', $colocation) }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Adresse email <span class="text-red-500">*</span>
                        </label>
                        <input type="email" 
                               name="email" 
                               id="email" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                               placeholder="exemple@email.com"
                               required>
                    </div>

                    <div class="flex gap-3">
                        <button type="submit" class="btn-primary flex-1 justify-center">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M22 2L11 13" />
                                <path d="M22 2l-7 20-4-9-9-4 20-7z" />
                            </svg>
                            Envoyer l'invitation
                        </button>
                        <button type="button" onclick="closeInviteModal()" class="btn-secondary flex-1 justify-center">
                            Annuler
                        </button>
                    </div>
                </form>
            </div>
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

    @if(auth()->user()->memberships->where('colocation_id', $colocation->id)->first()?->membership_role === 'owner')
        <div class="flex gap-2 mb-6">
            <a href="{{ route('categories.index', $colocation) }}" class="btn-secondary">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="3" width="8" height="8" rx="2" />
                    <rect x="13" y="3" width="8" height="8" rx="2" />
                    <rect x="3" y="13" width="8" height="8" rx="2" />
                    <rect x="13" y="13" width="8" height="8" rx="2" />
                </svg>
                Gerer les categories
            </a>
        </div>
    @endif

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
                    @if(!$membership->left_at)
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

                            @if(
                                    auth()->user()->memberships->where('colocation_id', $colocation->id)->first()?->membership_role === 'owner'
                                    && auth()->id() !== $membership->user_id
                                )
                                <form action="{{ route('colocation.kick', [$colocation, $membership])}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-danger text-sm py-1 px-3"
                                        onclick="return confirm('Retirer ce membre ?')">
                                        Retirer
                                    </button>
                                </form>
                            @endif
                        </div>
                    @endif
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
            <form method="GET" class="mb-4 flex gap-3 items-center">
    <label class="text-sm">Filtrer par mois :</label>

    <select name="month" onchange="this.form.submit()" class="border rounded px-3 py-1">
        <option value="">Tous les mois</option>

        @for($m = 1; $m <= 12; $m++)
            <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>
                {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
            </option>
        @endfor
    </select>
</form>
            <a href="{{ route('expenses.create', $colocation) }}" class="btn-primary text-sm py-1.5 px-3">
                + Nouvelle depense
            </a>
        </div>
        <div class="card-body">
            @if($expenses->count() > 0)
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
                            @foreach($expenses as $expense)
                                <tr>
                                    <td>{{ $expense->expense_date }}</td>
                                    <td class="font-medium">
                                        <a href="{{ route('expenses.show', [$colocation, $expense]) }}" class="hover:text-orange-600">
                                            {{ $expense->title }}
                                        </a>
                                    </td>
                                    <td>
                                        <div class="flex items-center gap-2">
                                            <div class="member-avatar w-6 h-6 text-xs">
                                                {{ strtoupper(substr($expense->payer->name, 0, 1)) }}
                                            </div>
                                            {{ $expense->payer->name }}
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge"
                                            style="background: {{ $expense->category->color }}20; color: {{ $expense->category->color }};">
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
                    <a href="{{ route('expenses.create', $colocation) }}" class="btn-primary">
                        Ajouter une depense
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- JavaScript pour le modal -->
<script>
    function openInviteModal() {
        document.getElementById('inviteModal').style.display = 'flex';
        document.body.style.overflow = 'hidden'; // Empecher le scroll
    }

    function closeInviteModal() {
        document.getElementById('inviteModal').style.display = 'none';
        document.body.style.overflow = 'auto'; // Reactiver le scroll
    }

    // Fermer le modal si on clique en dehors
    window.onclick = function(event) {
        const modal = document.getElementById('inviteModal');
        if (event.target === modal) {
            closeInviteModal();
        }
    }

</script>

<style>
    #inviteModal {
        animation: fadeIn 0.3s ease-out;
    }

    #inviteModal .bg-white {
        animation: slideIn 0.3s ease-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes slideIn {
        from {
            transform: translateY(-20px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }
</style>
@endsection