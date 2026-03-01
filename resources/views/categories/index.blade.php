@extends('layouts.user')

@section('page-title', 'Categories - ' . $colocation->name)

@section('content')
<div class="container mx-auto">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-xl font-semibold">Gestion des categories</h2>
            <p class="text-gray-600 text-sm">{{ $colocation->name }}</p>
        </div>
        
        @if($isOwner)
            <a href="{{ route('categories.create', $colocation) }}" class="btn-primary">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <line x1="12" y1="5" x2="12" y2="19" />
                    <line x1="5" y1="12" x2="19" y2="12" />
                </svg>
                Nouvelle categorie
            </a>
        @endif
</div>


    <!-- Categories personnalisees -->
    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <span>🎨</span>
                Categories personnalisees
            </div>
            @if($isOwner)
                <span class="text-sm text-gray-500">Vous pouvez les modifier</span>
            @endif
        </div>
        <div class="card-body">
            @php
                $customCategories = $categories->where('colocation_id', $colocation->id);
            @endphp

            @if($customCategories->count() > 0)
                <div class="grid md:grid-cols-2 gap-4">
                    @foreach($customCategories as $category)
                        <div class="border rounded-lg p-4">
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg" style="background: {{ $category->color }}"></div>
                                    <span class="font-semibold">{{ $category->name }}</span>
                                </div>
                            
                            @if($isOwner)
                                    <a href="{{ route('categories.edit', [$colocation, $category]) }}" 
                                       class="text-sm text-blue-500 hover:text-blue-600">
                                        Modifier
                                    </a>
                                    
                                    @if($category->usage_count == 0)
                                        <form action="{{ route('categories.destroy', [$colocation, $category]) }}" 
                                              method="POST" 
                                              class="inline"
                                              onsubmit="return confirm('Supprimer cette categorie ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-sm text-red-500 hover:text-red-600">
                                                Supprimer
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-sm text-gray-400" title="Categorie utilisee">Utilisee</span>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-state-icon">🏷️</div>
                    <div class="empty-state-title">Aucune categorie personnalisee</div>
                    <div class="empty-state-text">
                        @if($isOwner)
                            Creez vos propres categories pour mieux organiser vos depenses.
                        @else
                            Seul le proprietaire peut creer des categories personnalisees.
                        @endif
                    </div>
                    @if($isOwner)
                        <a href="{{ route('categories.create', $colocation) }}" class="btn-primary">
                            Creer une categorie
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>
@endsection