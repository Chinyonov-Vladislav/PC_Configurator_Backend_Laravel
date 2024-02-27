<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Modular_power_supply_type extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function power_supplies(): HasMany
    {
        return $this->hasMany(Power_supply::class, "modular_type_id");
    }
}
