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
        $totalPaid = $colocation->expenses()->where('payer_id', $user->id)->sum('amount');

        $totalOwed = DB::table('payments')->join('expenses', 'payments.expense_id', '=', 'expenses.id')
            ->where('expenses.colocation_id', $colocation->id)
            ->where('payments.user_id', $user->id)
            ->where('payments.is_paid', false)
            ->sum('payments.amount');


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

        $membership->update([
            'left_at' => now(),
        ]);        
        
    }
}