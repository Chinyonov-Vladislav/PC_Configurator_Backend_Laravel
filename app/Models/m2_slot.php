<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class m2_slot extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function m2_form_factors(): BelongsToMany
    {
        return $this->belongsToMany(m2_form_factor::class,"supported_m2_slot_form_factors",
            "m2_slot_id","m2_form_factor_id");
    }
    public function motherboards(): BelongsToMany
    {
        return $this->belongsToMany(Motherboard::class,"motherboard_m2_slots",
            "m2_slot_id","motherboard_id");
    }
}
