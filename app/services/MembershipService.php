<?php

namespace App\Services;

use App\Models\Colocation;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class MembershipService
{
    public function leave(Colocation $colocation, User $user): void
    {
        $membership = $colocation->memberships()->where('user_id', $user->id)->whereNull('left_at')->first();

        if (!$membership) {
            throw new \Exception('not_member');
        }

        if ($membership->membership_role === 'owner') {
            throw new \Exception('owner_cannot_leave');
        }

        $debts = $this->calculateDebts($colocation, $user);

        DB::transaction(function () use ($membership, $debts, $user) {

            $membership->update([
                'left_at' => now(),
            ]);

            $user->reputation += $debts['total_owed'] > 0 ? -1 : 1;
            $user->save();
        });
    }

    private function calculateDebts(Colocation $colocation, User $user): array
    {
        $expenses = $colocation->expenses()->with([
            'payments' => function ($query) use ($user) {
                $query->where('user_id', $user->id);
            }
        ])->get();

        $totalOwed = 0;

        $totalPaid = $colocation->expenses()->where('payer_id', $user->id)->sum('amount');

        foreach ($expenses as $expense) {
            foreach ($expense->payments as $payment) {
                if (!$payment->is_paid) {
                    $totalOwed += $payment->amount;
                }
            }
        }

        return [
            'total_paid' => $totalPaid,
            'total_owed' => $totalOwed,
            'balance' => $totalPaid - $totalOwed,
        ];
    }
}