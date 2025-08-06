<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Beer extends Model
{
    //
    protected $fillable = ['name', 'type', 'price'];

    public function locations(): HasMany
    {
        return $this->hasMany(Location::class);
    }
}
