<?php
// app/Http/Controllers/ExpenseController.php

namespace App\Http\Controllers;

use App\Http\Requests\ExpenseRequest;
use App\Models\Colocation;
use App\Models\Expense;
use App\Models\Payment;
use App\Services\ExpenseService;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    protected $expenseService;

    public function __construct(ExpenseService $expenseService)
    {
        $this->expenseService = $expenseService;
    }

    /**
     * Formulaire de creation
     */
    public function create(Colocation $colocation)
    {
        $isMember = $colocation->memberships()->where('user_id', Auth::id())->whereNull('left_at')->exists();

        if (!$isMember) {
            return redirect()->route('dashboard')->with('error', 'Vous n\'etes pas membre de cette colocation.');
        }

        $categories = $colocation->categories;

        return view('expenses.create', compact('colocation', 'categories'));
    }

    public function store(ExpenseRequest $request, Colocation $colocation)
    {
        try {
            $this->expenseService->create(
                $request->validated(),
                $colocation,
                Auth::user()
            );

            return redirect()->route('colocation.show', $colocation)->with('success', 'Depense ajoutee avec succes !');

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function show(Colocation $colocation, Expense $expense)
    {

        $isMember = $colocation->memberships()->where('user_id', Auth::id())->whereNull('left_at')->exists();

        if (!$isMember) {
            return redirect()->route('dashboard')->with('error', 'Vous n\'etes pas membre de cette colocation.');
        }

        $expense->load(['payer', 'category', 'payments.user']);

        return view('expenses.show', compact('colocation', 'expense'));
    }

    /**
     * Supprimer une depense
     */
    public function destroy(Colocation $colocation, Expense $expense)
    {
        try {
            $this->expenseService->delete($expense, Auth::user());
            return redirect()->route('colocation.show', $colocation)->with('success', 'Depense supprimee avec succes !');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Marquer un paiement comme effectue
     */
    public function markPayment(Colocation $colocation, Payment $payment)
    {
        $expense = $payment->expense;
        $memberCanMakePaymentId = $expense->payer_id;
        if(Auth::id() !== $memberCanMakePaymentId) {
            return back()->with('error', 'Vous ne pouvez pas effectuer ce paiement.');
        }
        try {
            $this->expenseService->markAsPaid($payment);
            return redirect()->back()->with('success', 'Paiement marque comme effectue !');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}