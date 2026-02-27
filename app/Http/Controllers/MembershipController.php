<?php

namespace App\Http\Controllers;

use App\Models\Colocation;
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
}