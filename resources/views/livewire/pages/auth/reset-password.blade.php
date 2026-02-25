<?php

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {
    #[Locked]
    public string $token = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Mount the component.
     */
    public function mount(string $token): void
    {
        $this->token = $token;
        $this->email = request()->string('email');
    }

    /**
     * Reset the password for the given user.
     */
    public function resetPassword(): void
    {
        $this->validate([
            'token' => ['required'],
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $status = Password::reset(
            $this->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) {
                $user->forceFill([
                    'password' => Hash::make($this->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status != Password::PASSWORD_RESET) {
            $this->addError('email', __($status));
            return;
        }

        Session::flash('status', __($status));
        $this->redirectRoute('login', navigate: true);
    }
}; ?>

<div>
    <form wire:submit="resetPassword">
        {{-- Email Address --}}
        <div>
            <label for="email">Adresse email</label>
            <input wire:model="email" id="email" type="email" name="email" required autofocus autocomplete="username"
                placeholder="exemple@email.com">
            <x-input-error :messages="$errors->get('email')" class="auth-error" />
        </div>

        {{-- Password --}}
        <div style="margin-top: 1.1rem;">
            <label for="password">Nouveau mot de passe</label>
            <input wire:model="password" id="password" type="password" name="password" required
                autocomplete="new-password" placeholder="••••••••">
            <x-input-error :messages="$errors->get('password')" class="auth-error" />
        </div>

        {{-- Confirm Password --}}
        <div style="margin-top: 1.1rem;">
            <label for="password_confirmation">Confirmer le nouveau mot de passe</label>
            <input wire:model="password_confirmation" id="password_confirmation" type="password"
                name="password_confirmation" required autocomplete="new-password" placeholder="••••••••">
            <x-input-error :messages="$errors->get('password_confirmation')" class="auth-error" />
        </div>

        {{-- Submit --}}
        <button type="submit" class="btn-primary">
            Réinitialiser le mot de passe
        </button>
    </form>

    <div class="auth-footer-link">
        <a href="{{ route('login') }}" wire:navigate>← Retour à la connexion</a>
    </div>
</div>