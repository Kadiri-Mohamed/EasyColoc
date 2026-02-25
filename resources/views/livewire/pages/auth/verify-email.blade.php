<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {
    /**
     * Send an email verification notification to the user.
     */
    public function sendVerification(): void
    {
        if (Auth::user()->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
            return;
        }

        Auth::user()->sendEmailVerificationNotification();
        Session::flash('status', 'verification-link-sent');
    }

    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();
        $this->redirect('/', navigate: true);
    }
}; ?>

<div>
    {{-- Icon --}}
    <div style="text-align:center; margin-bottom:1.25rem;">
        <div style="
            display:inline-flex;
            align-items:center;
            justify-content:center;
            width:60px; height:60px;
            background: linear-gradient(135deg, #FFF0DD, #f7e0c0);
            border-radius:50%;
            border: 2px solid #E2A16F;
        ">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#E2A16F" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round">
                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                <polyline points="22,6 12,13 2,6" />
            </svg>
        </div>
    </div>

    <p style="font-size:0.9rem; color:#6b7280; margin-bottom:1.25rem; line-height:1.6; text-align:center;">
        Merci de vous être inscrit ! Avant de commencer, veuillez vérifier votre adresse email en cliquant sur le lien
        que nous venons de vous envoyer.
    </p>

    @if (session('status') == 'verification-link-sent')
        <div style="
                background: #f0fdf4;
                border: 1px solid #86efac;
                border-radius: 10px;
                padding: 0.75rem 1rem;
                color: #16a34a;
                font-size: 0.88rem;
                margin-bottom: 1.25rem;
                text-align:center;
            ">
            ✓ Un nouveau lien de vérification a été envoyé à votre adresse email.
        </div>
    @endif

    <button wire:click="sendVerification" type="button" class="btn-primary">
        Renvoyer l'email de vérification
    </button>

    <div class="auth-footer-link" style="margin-top:1rem;">
        <button wire:click="logout" type="button"
            style="background:none; border:none; cursor:pointer; color:#86B0BD; font-size:0.88rem; font-weight:500; text-decoration:underline;">
            Se déconnecter
        </button>
    </div>
</div>