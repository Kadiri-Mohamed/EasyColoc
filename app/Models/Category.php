<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = [
        'name',
    ];

    //  RELATIONS
    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class);
    }
    
    public function colocations(): HasMany
    {
        return $this->hasMany(Colocation::class);
    }
}
