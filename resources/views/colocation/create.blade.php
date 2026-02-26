{{-- resources/views/colocation/create.blade.php --}}
@extends('layouts.user')

@section('page-title', 'Créer une colocation')

@section('content')
<div class="container mx-auto max-w-2xl">
    <div class="mb-6">
        <a href="{{ route('dashboard') }}" class="text-orange-500 hover:text-orange-600 flex items-center gap-1">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="19" y1="12" x2="5" y2="12" />
                <polyline points="12 19 5 12 12 5" />
            </svg>
            Retour au tableau de bord
        </a>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <span>🏠</span>
                Créer une nouvelle colocation
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('colocation.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nom de la colocation <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="name" 
                           id="name" 
                           value="{{ old('name') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                           placeholder="Ex: Appartement Centre, Maison de campagne..."
                           required>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Description (optionnelle)
                    </label>
                    <textarea name="description" 
                              id="description" 
                              rows="4"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                              placeholder="Décrivez votre colocation, son emplacement, ses règles...">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-3 mt-6">
                    <button type="submit" class="btn-primary flex-1 justify-center">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="12" y1="5" x2="12" y2="19" />
                            <line x1="5" y1="12" x2="19" y2="12" />
                        </svg>
                        Créer la colocation
                    </button>
                    <a href="{{ route('dashboard') }}" class="btn-secondary flex-1 justify-center">
                        Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection