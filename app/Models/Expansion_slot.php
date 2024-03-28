<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Expansion_slot extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function computer_cases(): BelongsToMany
    {
        return $this->belongsToMany(Computer_case::class, "computer_case_expansion_slots",
            "expansion_slot_id","computer_case_id");
    }
}
