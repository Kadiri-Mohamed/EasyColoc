<?php

namespace App\Http\Controllers;

use App\Models\Colocation;
use App\Models\Membership;
use App\Services\MembershipService;
use Illuminate\Support\Facades\Auth;

class MembershipController extends Controller
{
    public function leaveColocation(Colocation $colocation, MembershipService $service)
    {
        try {
            $service->leave($colocation, Auth::user());
            return redirect()->route('dashboard')->with('success', 'Vous avez quitte la colocation.');
        } catch (\Exception $e) {
            return match ($e->getMessage()) {
                'not_member' => redirect()->route('dashboard')->with('error', 'Vous n etes pas membre.'),
                'owner_cannot_leave' => redirect()->route('colocation.show', $colocation)->with('error', 'Le proprietaire doit annuler la colocation.'),
                default => redirect()->route('dashboard')->with('error', 'Une erreur est survenue.'),
            };
        }
    }

    public function kickMember(Colocation $colocation, MembershipService $service, Membership $membership){
        try {
            $service->kick($colocation, $membership);
            return redirect()->route('colocation.show', $colocation)->with('success', 'Membre expulse.');
        } catch (\Exception $e) {
            return redirect()->route('colocation.show', $colocation)->with('error', 'Une erreur est survenue.');
        }
    }
}