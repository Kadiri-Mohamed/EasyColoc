<?php

namespace App\Http\Controllers;

use App\Models\Colocation;
use App\Models\Invitation;
use App\Services\InvitationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvitationController extends Controller
{
    protected $invitationService;

    public function __construct(InvitationService $invitationService)
    {
        $this->invitationService = $invitationService;
    }

    /**
     * Envoyer une invitation
     */
    public function store(Request $request, Colocation $colocation)
    {
        $request->validate([
            'email' => 'required|email|max:255',
        ]);

        try {
            $invitation = $this->invitationService->create(
                $request->only('email'),
                $colocation,
                Auth::user()
            );

            return redirect()->back()->with('success', 'Invitation envoyée à ' . $request->email);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    /**
     * Accepter une invitation
     */
    public function accept($token)
    {
        try {
            $result = $this->invitationService->accept($token, Auth::user());

            if ($result['requires_register']) {
                session(['invitation_token' => $token]);
                return redirect()->route('register')
                    ->with('info', 'Creez un compte pour rejoindre la colocation.');
            }

            $colocation = $result['invitation']->colocation;
            return redirect()->route('colocation.show', $colocation)
                ->with('success', 'Vous avez rejoint la colocation avec succes !');

        } catch (\Exception $e) {
            return redirect()->route('dashboard')
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Refuser une invitation
     */
    public function reject($token)
    {
        try {
            $this->invitationService->reject($token);
            return redirect()->route('dashboard')
                ->with('success', 'Invitation refusee.');
        } catch (\Exception $e) {
            return redirect()->route('dashboard')
                ->with('error', $e->getMessage());
        }
    }
}