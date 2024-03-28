<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Connector extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function computer_case_fans(): HasMany
    {
        return $this->hasMany(Computer_case_fan::class,"connector_id");
    }
    public function power_supplies(): BelongsToMany
    {
        return $this->belongsToMany(Power_supply::class, "power_supply_connectors",
            "connector_id","power_supply_id");
    }
}
