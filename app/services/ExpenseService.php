<?php
// app/Services/ExpenseService.php

namespace App\Services;

use App\Models\Colocation;
use App\Models\Expense;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ExpenseService
{
    public function create(array $data, Colocation $colocation, User $payer): Expense
    {
        $isMember = $colocation->memberships()->where('user_id', $payer->id)->whereNull('left_at')->exists();

        if (!$isMember) {
            throw new \Exception('Vous devez etre membre de la colocation.');
        }

        return DB::transaction(function () use ($data, $colocation, $payer) {
            $data['payer_id'] = $payer->id;
            
            $expense = Expense::create($data);
            
            $members = $colocation->memberships()->whereNull('left_at')->where('user_id', '!=', $payer->id)->get();
            
            $share = $expense->amount / ($members->count() + 1);
            
            foreach ($members as $member) {
                Payment::create([
                    'amount' => $share,
                    'user_id' => $member->user_id,
                    'expense_id' => $expense->id,
                    'is_paid' => false,
                ]);
            }
            
            return $expense;
        });
    }


    public function delete(Expense $expense, User $user): void
    {
        if ($expense->payer_id !== $user->id) {
            throw new \Exception('Vous n\'etes pas autorise a supprimer cette depense.');
        }

        DB::transaction(function () use ($expense) {
            $expense->payments()->delete();
            $expense->delete();
        });
    }

    public function markAsPaid(Payment $payment): void
    {
        if ($payment->is_paid) {
            throw new \Exception('Ce paiement est deja marque comme effectue.');
        }

        $payment->update([
            'is_paid' => true,
            'paid_at' => now(),
        ]);
    }
}