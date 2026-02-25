<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>
    {{-- Session Status --}}
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="login">
        {{-- Email Address --}}
        <div>
            <label for="email">Adresse email</label>
            <input wire:model="form.email" id="email" type="email" name="email" required autofocus
                autocomplete="username" placeholder="exemple@email.com">
            <x-input-error :messages="$errors->get('form.email')" class="auth-error" />
        </div>

        {{-- Password --}}
        <div style="margin-top: 1.1rem;">
            <label for="password">Mot de passe</label>
            <input wire:model="form.password" id="password" type="password" name="password" required
                autocomplete="current-password" placeholder="••••••••">
            <x-input-error :messages="$errors->get('form.password')" class="auth-error" />
        </div>

        {{-- Remember Me + Forgot Password --}}
        <div style="display:flex; align-items:center; justify-content:space-between; margin-top:1rem;">
            <label
                style="display:flex; align-items:center; gap:0.5rem; cursor:pointer; font-weight:400; color:#6b7280;">
                <input wire:model="form.remember" id="remember" type="checkbox" name="remember">
                <span style="font-size:0.88rem;">Se souvenir de moi</span>
            </label>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" wire:navigate>
                    Mot de passe oublié ?
                </a>
            @endif
        </div>

        {{-- Submit --}}
        <button type="submit" class="btn-primary">
            Se connecter
        </button>
    </form>

    <div class="auth-footer-link">
        Pas encore de compte ?
        <a href="{{ route('register') }}" wire:navigate>Créer un compte</a>
    </div>
</div>