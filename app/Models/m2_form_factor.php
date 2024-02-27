<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class m2_form_factor extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function m2_slots(): BelongsToMany
    {
        return $this->belongsToMany(m2_slot::class,"supported_m2_slot_form_factors",
            "m2_form_factor_id","m2_slot_id");
    }
}
