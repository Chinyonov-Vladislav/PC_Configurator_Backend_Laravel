<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Output_power_supply_type extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function power_supplies(): BelongsToMany
    {
        return $this->belongsToMany(Power_supply::class,"power_supply_outputs",
            "output_type_id","power_supply_id");
    }
}
