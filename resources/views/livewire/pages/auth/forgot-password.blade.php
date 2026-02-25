<?php

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {
    public string $email = '';

    /**
     * Send a password reset link to the provided email address.
     */
    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        $status = Password::sendResetLink(
            $this->only('email')
        );

        if ($status != Password::RESET_LINK_SENT) {
            $this->addError('email', __($status));
            return;
        }

        $this->reset('email');
        session()->flash('status', __($status));
    }
}; ?>

<div>
    <p style="font-size:0.9rem; color:#6b7280; margin-bottom:1.4rem; line-height:1.6;">
        Mot de passe oublié ? Pas de problème. Indiquez votre adresse email et nous vous enverrons un lien de
        réinitialisation.
    </p>

    {{-- Session Status --}}
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="sendPasswordResetLink">
        {{-- Email Address --}}
        <div>
            <label for="email">Adresse email</label>
            <input wire:model="email" id="email" type="email" name="email" required autofocus
                placeholder="exemple@email.com">
            <x-input-error :messages="$errors->get('email')" class="auth-error" />
        </div>

        {{-- Submit --}}
        <button type="submit" class="btn-primary">
            Envoyer le lien de réinitialisation
        </button>
    </form>

    <div class="auth-footer-link">
        <a href="{{ route('login') }}" wire:navigate>← Retour à la connexion</a>
    </div>
</div>