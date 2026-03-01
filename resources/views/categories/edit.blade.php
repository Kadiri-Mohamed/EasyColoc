@extends('layouts.user')

@section('page-title', 'Modifier - ' . $category->name)

@section('content')
<div class="container mx-auto max-w-2xl">
    <div class="mb-6">
        <a href="{{ route('categories.index', $colocation) }}" class="text-orange-500 hover:text-orange-600 flex items-center gap-1">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="19" y1="12" x2="5" y2="12" />
                <polyline points="12 19 5 12 12 5" />
            </svg>
            Retour aux categories
        </a>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <span>✏️</span>
                Modifier la categorie
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('categories.update', [$colocation, $category]) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nom de la categorie <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="name" 
                           id="name" 
                           value="{{ old('name', $category->name) }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                           required>
                </div>


                <div class="flex gap-3">
                    <button type="submit" class="btn-primary flex-1 justify-center">
                        Mettre a jour
                    </button>
                    <a href="{{ route('categories.index', $colocation) }}" class="btn-secondary flex-1 justify-center">
                        Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection