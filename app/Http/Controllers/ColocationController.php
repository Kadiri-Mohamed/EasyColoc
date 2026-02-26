<?php

namespace App\Http\Controllers;

use App\Http\Requests\ColocationRequest;
use App\Models\Colocation;
use App\Models\Membership;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ColocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $colocations = $user->colocations()->withPivot('membership_role', 'joined_at', 'left_at')->orderByDesc('created_at')->get();

        $activeColocation = $user->colocations()->wherePivotNull('left_at')->first();
        return view('colocation.index', compact('colocations', 'activeColocation'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $hasActiveColocation = Auth::user()->colocations()->wherePivotNull('left_at')->exists();

        if ($hasActiveColocation) {
            return redirect()->route('dashboard')->with('error', 'Vous avez deja une colocation active. Vous devez la quitter avant d en creer une nouvelle.');
        }
        return view('colocation.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ColocationRequest $request)
    {
        $hasActiveColocation = Auth::user()->colocations()
            ->wherePivotNull('left_at')
            ->exists();

        if ($hasActiveColocation) {
            return redirect()->route('dashboard')->with('error', 'Vous avez deja une colocation active.');
        }

        DB::beginTransaction();

        try {
            $colocation = Colocation::create($request->validated());

            // Membership::create([
            //     'user_id' => Auth::id(),
            //     'colocation_id' => $colocation->id,
            //     'membership_role' => 'owner',
            // ]);

            session()->flash('success', 'Colocation creee avec succès !');
            session()->flash('colocation_id', $colocation->id);

            return redirect()->route('colocation.index');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('colocation.create')->with('error', 'Une erreur est survenue lors de la creation de la colocation. Veuillez reessayer.');
        }
    }

    public function activeColocation(Colocation $colocation)
    {

    }

    public function cancelColocation(Colocation $colocation)
    {

    }

    public function show(Colocation $colocation)
    {
        $user = Auth::user();
        $membership = $colocation->memberships()->where('user_id', $user->id);

        if (!$membership) {
            return redirect()->route('dashboard')->with('error', 'Vous n etes pas membre de cette colocation.');
        }

        $colocation->load(['memberships','expenses']);

        $totalExpenses = $colocation->expenses()->sum('amount');
        $memberCount = $colocation->memberships()->whereNull('left_at')->count();

        $balances = $this->calculateBalances($colocation);

        return view('colocation.show', compact(
            'colocation',
            'totalExpenses',
            'memberCount',
            'balances'
        ));
    }
    private function calculateBalances(Colocation $colocation)
    {
        $members = $colocation->memberships()->whereNull('left_at')->with('user')->get();
        $expenses = $colocation->expenses()->with('payments')->get();

        $balances = [];

        foreach ($members as $member) {
            $paid = 0;
            $owed = 0;

            foreach ($expenses->where('payer_id', $member->user_id) as $expense) {
                $paid += $expense->amount;
            }

            foreach ($expenses as $expense) {
                $payment = $expense->payments()
                    ->where('user_id', $member->user_id)
                    ->first();

                if ($payment && !$payment->is_paid) {
                    $owed += $payment->amount;
                }
            }

            $balances[$member->user_id] = [
                'user' => $member->user,
                'paid' => $paid,
                'owed' => $owed,
                'balance' => $paid - $owed,
            ];
        }

        return $balances;
    }

}
