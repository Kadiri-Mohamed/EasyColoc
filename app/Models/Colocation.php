<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Colocation extends Model
{
    protected $fillable = [
        'name',
        'description',
        'status',    
        'category_id',
    ];

    //  RELATIONS

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'memberships')
            ->using(Membership::class)
            ->withPivot(['membership_role', 'joined_at', 'left_at'])
            ->withTimestamps();
    }

    public function memberships(): HasMany
    {
        return $this->hasMany(Membership::class);
    }

    public function invitations(): HasMany
    {
        return $this->hasMany(Invitation::class);
    }

    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class);
    }
}
