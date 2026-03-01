<?php

namespace App\Services;

use App\Models\Colocation;
use App\Models\Membership;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
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

    public function kick(Colocation $colocation, Membership $membership): void
    {
        $owner = $colocation->memberships()->where('user_id', '=',Auth::id())->where('membership_role' , '=','owner')->first();

        if (!$owner) {
            throw new \Exception('no_owner');
        }

        if ($owner->id === $membership->id) {
            throw new \Exception('owner_cannot_be_kicked');
        }

          DB::transaction(function () use ($colocation, $membership, $owner) {
            $user = $membership->user;
            $debts = $this->calculateDebts($colocation, $user);

            if ($debts['total_owed'] > 0) {
                $this->transferDebtsToOwner($colocation, $user, $owner->user);

                $user->reputation -= 1;
                $user->save();

            } else {

                $membership->update([
                    'left_at' => now(),
                ]);
            }
        });

    }

    private function transferDebtsToOwner(Colocation $colocation, User $user, User $owner): void
    {
        $expenses = $colocation->expenses()->with([
            'payments' => function ($query) use ($user) {
                $query->where('user_id', $user->id);
            }
        ])->get();

        foreach ($expenses as $expense) {
            foreach ($expense->payments as $payment) {
                if (!$payment->is_paid) {
                    $payment->update([
                        'user_id' => $owner->id,
                        'is_paid' => true,
                    ]);
                }
            }
        }
    }
    
}