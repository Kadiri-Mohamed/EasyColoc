<?php
// app/Services/InvitationService.php

namespace App\Services;

use App\Mail\InvitationMail;
use App\Models\Colocation;
use App\Models\Invitation;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class InvitationService
{
      private function sendInvitationEmail(Invitation $invitation, Colocation $colocation, User $inviter)
    {
        Mail::to($invitation->email)->send(new InvitationMail($invitation, $colocation, $inviter));
    }

    /**
     * Creer une invitation
     */
    public function create(array $data, Colocation $colocation, User $inviter): Invitation
    {
        $isOwner = $colocation->memberships()->where('user_id', $inviter->id)->where('membership_role', 'owner')->exists();

        if (!$isOwner) {
            throw new \Exception('Seul le proprietaire peut inviter des membres.');
        }

        $existingUser = User::where('email', $data['email'])->first();
        if ($existingUser) {
            $isMember = $colocation->memberships()->where('user_id', $existingUser->id)->whereNull('left_at')->exists();
            if ($isMember) {
                throw new \Exception('Cet utilisateur est deja membre de la colocation.');
            }
        }

        $existingInvitation = $colocation->invitations()->where('email', $data['email'])->where('status', 'pending')->first();

        if ($existingInvitation) {
            throw new \Exception('Une invitation est deja en attente pour cet email.');
        }

        $invitation = Invitation::create([
            'email' => $data['email'],
            'token' => Str::random(60),
            'colocation_id' => $colocation->id,
            'status' => 'pending',
        ]);

        $this->sendInvitationEmail($invitation, $colocation, $inviter);
        return $invitation;
    }

    /**
     * Accepter 
     */
    public function accept(string $token, User $user): array
    {
        $invitation = Invitation::where('token', $token)->where('status', 'pending')->first();

        if (!$invitation) {
            throw new \Exception('Invitation non trouvee.');
        }

        if (!$user) {
            return ['invitation' => $invitation, 'requires_register' => true];
        }

        if ($user->email !== $invitation->email) {
            throw new \Exception('Cette invitation est pour un autre email.');
        }

        $hasActiveColocation = $user->colocations()->wherePivotNull('left_at')->exists();

        if ($hasActiveColocation) {
            throw new \Exception('Vous avez deja une colocation active.');
        }

        DB::transaction(function () use ($invitation, $user) {
            $invitation->colocation->memberships()->create([
                'user_id' => $user->id,
                'membership_role' => 'member',
                'joined_at' => now(),
            ]);

            $invitation->update([
                'status' => 'accepted',
                'accepted_at' => now(),
            ]);
        });

        return ['invitation' => $invitation, 'requires_register' => false];
    }

    /**
     * Refuser
     */
    public function reject(string $token): void
    {
        $invitation = Invitation::where('token', $token)->where('status', 'pending')->first();

        if (!$invitation) {
            throw new \Exception('Invitation non trouvee.');
        }

        $invitation->update([
            'status' => 'rejected',
            'rejected_at' => now(),
        ]);
    }
  
}