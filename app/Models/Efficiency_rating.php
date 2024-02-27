<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Efficiency_rating extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function power_supplies(): HasMany
    {
        return $this->hasMany(Power_supply::class, "efficiency_rating_id");
    }
}
