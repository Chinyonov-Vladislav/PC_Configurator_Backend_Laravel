<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class sli_crossfire_type extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function motherboards(): BelongsToMany
    {
        return $this->belongsToMany(Motherboard::class,"motherboard_sli_crossfire_types",
            "sli_crossfire_type_id","motherboard_id");
    }
    public function graphical_cards(): HasMany
    {
        return $this->hasMany(Graphical_card::class,"sli_crossfire_type_id");
    }
}
