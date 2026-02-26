{{-- resources/views/colocation/index.blade.php --}}
@extends('layouts.user')

@section('page-title', 'Mes Colocations')

@section('content')
<div class="container mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold">Toutes mes colocations</h2>
        @if(!$activeColocation)
            <a href="{{ route('colocation.create') }}" class="btn-primary">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <line x1="12" y1="5" x2="12" y2="19" />
                    <line x1="5" y1="12" x2="19" y2="12" />
                </svg>
                Nouvelle colocation
            </a>
        @endif
    </div>

    @if($activeColocation)
        <div class="card mb-6 border-l-4 border-green-500" style="border-left-color: #10b981;">
            <div class="card-body">
                <div class="flex justify-between items-center">
                    <div>
                        <span class="badge badge-success mb-2">Active</span>
                        <h3 class="text-lg font-semibold">{{ $activeColocation->name }}</h3>
                        <p class="text-gray-600 text-sm mt-1">{{ $activeColocation->description }}</p>
                    </div>
                    <a href="{{ route('colocation.show', $activeColocation) }}" class="btn-primary">
                        Voir la colocation
                    </a>
                </div>
            </div>
        </div>
    @endif

    @if($colocations->count() > 0)
        <div class="grid-cols">
            @foreach($colocations as $colocation)
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <span>🏠</span>
                            {{ $colocation->name }}
                        </div>
                        <span class="badge {{ $colocation->pivot->left_at ? 'badge-danger' : 'badge-success' }}">
                            {{ $colocation->pivot->left_at ? 'Ancienne' : 'Active' }}
                        </span>
                    </div>
                    <div class="card-body">
                        <p class="text-gray-600 text-sm mb-4">
                            {{ $colocation->description ?: 'Aucune description' }}
                        </p>
                        
                        <div class="flex items-center justify-between text-sm mb-4">
                            <span class="text-gray-500">
                                Role: 
                                <span class="font-medium text-gray-700">
                                    {{ $colocation->pivot->membership_role === 'owner' ? 'Owner' : 'Membre' }}
                                </span>
                            </span>
                            <span class="text-gray-500">
                                {{ $colocation->pivot->joined_at }}
                            </span>
                        </div>

                        @if($colocation->pivot->left_at)
                            <div class="text-sm text-gray-500 border-t pt-3">
                                Quittee le {{ $colocation->pivot->left_at }}
                            </div>
                        @else
                            <div class="flex gap-2 mt-2">
                                <a href="{{ route('colocation.show', $colocation) }}" 
                                   class="flex-1 text-center px-3 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition text-sm font-medium">
                                    Details
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="card">
            <div class="empty-state">
                <div class="empty-state-icon">🏠</div>
                <div class="empty-state-title">Aucune colocation</div>
                <div class="empty-state-text">
                    Vous n'avez pas encore de colocation. Creez-en une pour commencer !
                </div>
                <a href="{{ route('colocation.create') }}" class="btn-primary">
                    Creer une colocation
                </a>
            </div>
        </div>
    @endif
</div>
@endsection