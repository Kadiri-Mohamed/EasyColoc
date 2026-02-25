<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered($user = User::create($validated)));

        Auth::login($user);

        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>
    <form wire:submit="register">
        {{-- Name --}}
        <div>
            <label for="name">Nom complet</label>
            <input wire:model="name" id="name" type="text" name="name" required autofocus autocomplete="name"
                placeholder="Jean Dupont">
            <x-input-error :messages="$errors->get('name')" class="auth-error" />
        </div>

        {{-- Email Address --}}
        <div style="margin-top: 1.1rem;">
            <label for="email">Adresse email</label>
            <input wire:model="email" id="email" type="email" name="email" required autocomplete="username"
                placeholder="exemple@email.com">
            <x-input-error :messages="$errors->get('email')" class="auth-error" />
        </div>

        {{-- Password --}}
        <div style="margin-top: 1.1rem;">
            <label for="password">Mot de passe</label>
            <input wire:model="password" id="password" type="password" name="password" required
                autocomplete="new-password" placeholder="••••••••">
            <x-input-error :messages="$errors->get('password')" class="auth-error" />
        </div>

        {{-- Confirm Password --}}
        <div style="margin-top: 1.1rem;">
            <label for="password_confirmation">Confirmer le mot de passe</label>
            <input wire:model="password_confirmation" id="password_confirmation" type="password"
                name="password_confirmation" required autocomplete="new-password" placeholder="••••••••">
            <x-input-error :messages="$errors->get('password_confirmation')" class="auth-error" />
        </div>

        {{-- Submit --}}
        <button type="submit" class="btn-primary">
            Créer mon compte
        </button>
    </form>

    <div class="auth-footer-link">
        Déjà un compte ?
        <a href="{{ route('login') }}" wire:navigate>Se connecter</a>
    </div>
</div>