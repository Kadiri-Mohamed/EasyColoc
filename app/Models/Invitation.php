<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invitation extends Model
{
    protected $fillable = [
        'email',
        'token',
        'status',
        'colocation_id',
        'accepted_at',
        'rejected_at',
    ];

    //  RELATIONS
   
    public function colocation(): BelongsTo
    {
        return $this->belongsTo(Colocation::class);
    }
}
