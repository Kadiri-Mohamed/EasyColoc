<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Colocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // ─ Active colocation ─
        $activeColocation = $user->colocations()->wherePivotNull('left_at')->with('members')->first();

        // ─ Total expenses ─
        $totalPaid = $user->paidExpenses()->sum('amount');

        // ─ Recent expenses ─
        $recentExpenses = $user->paidExpenses()->with(['category', 'payments'])->latest('expense_date')->take(5)->get();

        return view('dashboard', compact(
            'user',
            'activeColocation',
            'totalPaid',
            'recentExpenses'
        ));
    }

}
