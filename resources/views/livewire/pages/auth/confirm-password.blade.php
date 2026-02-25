<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {
    public string $password = '';

    /**
     * Confirm the current user's password.
     */
    public function confirmPassword(): void
    {
        $this->validate([
            'password' => ['required', 'string'],
        ]);

        if (
            !Auth::guard('web')->validate([
                'email' => Auth::user()->email,
                'password' => $this->password,
            ])
        ) {
            throw ValidationException::withMessages([
                'password' => __('auth.password'),
            ]);
        }

        session(['auth.password_confirmed_at' => time()]);

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>
    <p style="font-size:0.9rem; color:#6b7280; margin-bottom:1.4rem; line-height:1.6;">
        Vous accédez à une zone sécurisée. Veuillez confirmer votre mot de passe avant de continuer.
    </p>

    <form wire:submit="confirmPassword">
        {{-- Password --}}
        <div>
            <label for="password">Mot de passe</label>
            <input wire:model="password" id="password" type="password" name="password" required
                autocomplete="current-password" placeholder="••••••••">
            <x-input-error :messages="$errors->get('password')" class="auth-error" />
        </div>

        {{-- Submit --}}
        <button type="submit" class="btn-primary">
            Confirmer le mot de passe
        </button>
    </form>
</div>