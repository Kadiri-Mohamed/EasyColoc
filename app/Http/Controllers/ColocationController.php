<?php

namespace App\Http\Controllers;

use App\Http\Requests\ColocationRequest;
use App\Models\Colocation;
use App\Services\ColocationService;
use Illuminate\Support\Facades\Auth;

class ColocationController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $colocations = $user->colocations()->withPivot('membership_role', 'joined_at', 'left_at')->orderByDesc('created_at')->get();

        $activeColocation = $user->colocations()->wherePivotNull('left_at')->first();

        return view('colocation.index', compact('colocations', 'activeColocation'));
    }

    public function create()
    {
        return view('colocation.create');
    }

    public function store(ColocationRequest $request, ColocationService $service)
    {
        try {

            $service->create($request->validated(), Auth::user());

            return redirect()->route('colocation.index')->with('success', 'Colocation creee avec succes !');

        } catch (\Exception $e) {

            return redirect()->route('dashboard')->with('error', 'Vous avez deja une colocation active.');
        }
    }

    public function cancelColocation(Colocation $colocation, ColocationService $service)
    {
        try {

            $service->cancel($colocation, Auth::user());

            return redirect()->route('dashboard')->with('success', 'La colocation a ete annulee.');

        } catch (\Exception $e) {

            return redirect()->route('dashboard')->with('error', 'Seul le proprietaire peut annuler.');
        }
    }

    public function show(Colocation $colocation, ColocationService $service)
    {
        $totalExpenses = $colocation->expenses()->sum('amount');

        $memberCount = $colocation->memberships()->whereNull('left_at')->count();

        return view('colocation.show', compact(
            'colocation',
            'totalExpenses',
            'memberCount'
        ));
    }
}