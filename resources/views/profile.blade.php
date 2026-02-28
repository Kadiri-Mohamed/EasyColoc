@extends('layouts.user')

@section('page-title', 'Mon Profil')

@section('content')
<div class="container mx-auto max-w-4xl">
    <!-- Header avec titre -->
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Mon Profil</h2>
        <p class="text-gray-600">Gérez vos informations personnelles et vos préférences</p>
    </div>

    <!-- Cartes de profil -->
    <div class="space-y-6">
        <!-- Mise à jour des informations -->
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: #E2A16F;">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                        <circle cx="12" cy="7" r="4" />
                    </svg>
                    Informations personnelles
                </div>
            </div>
            <div class="card-body">
                <div class="max-w-2xl">
                    @livewire('profile.update-profile-information-form')
                </div>
            </div>
        </div>

        <!-- Mise à jour du mot de passe -->
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: #E2A16F;">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                        <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                    </svg>
                    Sécurité
                </div>
            </div>
            <div class="card-body">
                <div class="max-w-2xl">
                    @livewire('profile.update-password-form')
                </div>
            </div>
        </div>

        <!-- Suppression du compte -->
        <div class="card border-red-200">
            <div class="card-header bg-red-50">
                <div class="card-title text-red-600">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="3 6 5 6 21 6" />
                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0h10" />
                        <line x1="10" y1="11" x2="10" y2="17" />
                        <line x1="14" y1="11" x2="14" y2="17" />
                    </svg>
                    Zone dangereuse
                </div>
            </div>
            <div class="card-body">
                <div class="max-w-2xl">
                    @livewire('profile.delete-user-form')
                </div>
            </div>
        </div>
    </div>

    <!-- Information supplémentaire -->
    <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
        <div class="flex items-start gap-3">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-blue-600 flex-shrink-0 mt-0.5">
                <circle cx="12" cy="12" r="10" />
                <line x1="12" y1="16" x2="12" y2="12" />
                <line x1="12" y1="8" x2="12.01" y2="8" />
            </svg>
            <div>
                <h4 class="font-semibold text-blue-800">Informations de sécurité</h4>
                <p class="text-sm text-blue-700 mt-1">
                    Votre réputation actuelle est de <strong>{{ auth()->user()->reputation }}</strong> points. 
                    Plus vous payez vos dettes à temps, plus votre réputation augmente !
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

{{-- Styles additionnels pour les formulaires Livewire --}}
@push('styles')
<style>
    /* Adaptation des inputs au thème */
    .card input[type="text"],
    .card input[type="email"],
    .card input[type="password"] {
        border: 1.5px solid #D1D3D4;
        border-radius: 10px;
        padding: 0.65rem 0.9rem;
        font-size: 0.95rem;
        transition: border-color 0.2s, box-shadow 0.2s;
        width: 100%;
        background: #fafafa;
        color: #374151;
    }

    .card input[type="text"]:focus,
    .card input[type="email"]:focus,
    .card input[type="password"]:focus {
        border-color: #E2A16F;
        box-shadow: 0 0 0 3px rgba(226, 161, 111, 0.18);
        background: #ffffff;
        outline: none;
    }

    .card label {
        font-size: 0.85rem;
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.35rem;
        display: block;
    }

    /* Boutons des formulaires */
    .card button[type="submit"] {
        background: linear-gradient(135deg, #E2A16F, #c8834d) !important;
        color: #ffffff !important;
        border: none !important;
        border-radius: 10px !important;
        padding: 0.7rem 1.6rem !important;
        font-size: 0.95rem !important;
        font-weight: 600 !important;
        cursor: pointer !important;
        transition: transform 0.15s, box-shadow 0.15s !important;
        box-shadow: 0 4px 14px rgba(226, 161, 111, 0.4) !important;
    }

    .card button[type="submit"]:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(226, 161, 111, 0.5) !important;
    }

    /* Bouton secondaire (annuler) */
    .card button[type="button"] {
        background: #f3f4f6 !important;
        color: #374151 !important;
        border: 1px solid #e5e7eb !important;
        border-radius: 10px !important;
        padding: 0.7rem 1.6rem !important;
        font-size: 0.95rem !important;
        font-weight: 600 !important;
    }

    /* Messages de succès/erreur */
    .card .text-green-600 {
        color: #16a34a !important;
        background: #f0fdf4 !important;
        padding: 0.75rem 1rem !important;
        border-radius: 8px !important;
        border: 1px solid #86efac !important;
    }

    .card .text-red-600 {
        color: #dc2626 !important;
        background: #fef2f2 !important;
        padding: 0.75rem 1rem !important;
        border-radius: 8px !important;
        border: 1px solid #fca5a5 !important;
    }

    /* Section de suppression */
    .border-red-200 {
        border-color: #fecaca !important;
    }

    .bg-red-50 {
        background: #fef2f2;
    }

    .text-red-600 {
        color: #dc2626;
    }
</style>
@endpush