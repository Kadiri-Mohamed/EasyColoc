<?php

namespace App\Services;

use App\Models\Colocation;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ColocationService
{
    public function create(array $data, User $user): Colocation
    {
        if ($this->hasActiveColocation($user)) {
            throw new \Exception('already_active');
        }

        return DB::transaction(function () use ($data, $user) {

            $colocation = Colocation::create($data);

            $colocation->memberships()->create([
                'user_id' => $user->id,
                'membership_role' => 'owner',
            ]);

            return $colocation;
        });
    }

    public function cancel(Colocation $colocation, User $user): void
    {
        $membership = $colocation->memberships()->where('user_id', $user->id)->first();

        if (!$membership || $membership->membership_role !== 'owner') {
            throw new \Exception('not_owner');
        }

        DB::transaction(function () use ($colocation) {

            $colocation->update([
                'status' => 'cancelled'
            ]);

            $colocation->memberships()->whereNull('left_at')->update(['left_at' => now()]);
        });
    }

    private function hasActiveColocation(User $user): bool
    {
        return $user->colocations()->wherePivotNull('left_at')->exists();
    }
}