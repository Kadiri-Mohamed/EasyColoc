<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Colocation;
use App\Models\Expense;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // ─ users ─
        $allUsers = User::all();
        $totalUsers = User::count();
        $bannedUsers = User::where('is_banned', true)->count();

        // ─ Statistiques ─
        $activeColocations = Colocation::where('status', 'active')->count();
        $totalExpensesAmount = Expense::sum('amount');

        return view('admin.dashboard', compact(['allUsers', 'totalUsers', 'bannedUsers', 'activeColocations', 'totalExpensesAmount']));
    }

    public function ban(Request $request, User $user)
    {
        if ($user->is_admin) {
            return back()->with('error', 'Impossible de bannir un admin');
        }

        if ($user->id === auth()->id()) {
            return back()->with('error', 'Vous ne pouvez pas vous bannir vous-meme');
        }

        $user->update([
            'is_banned' => true,
            'banned_at' => now(),
        ]);

        return back()->with('success', "L'utilisateur {$user->name} a ete banni avec succes");
    }
    public function unban(Request $request, User $user)
    {
        $user->update([
            'is_banned' => false,
            'banned_at' => null,
        ]);

        return back()->with('success', "L'utilisateur {$user->name} a ete debanni avec succes");
    }
}
