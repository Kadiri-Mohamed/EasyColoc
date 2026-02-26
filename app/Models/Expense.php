<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Expense extends Model
{
    protected $fillable = [
        'title',
        'description',
        'amount',
        'expense_date',
        'notes',
        'colocation_id',
        'payer_id',      
        'category_id',
    ];

    //  RELATIONS


    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function payer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'payer_id');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
}
