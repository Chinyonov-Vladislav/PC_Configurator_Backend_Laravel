<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Computer_part_chipset extends Model
{
    use HasFactory;
    public function chipset(): BelongsTo
    {
        return $this->belongsTo(Chipset::class, "chipset_id");
    }

    public function motherboards(): HasMany
    {
        return $this->hasMany(Motherboard::class, "chipset_id");
    }
    public function sound_cards(): HasMany
    {
        return $this->hasMany(Sound_card::class, "chipset_sound_card_id");
    }
    public function graphical_cards(): HasMany
    {
        return $this->hasMany(Graphical_card::class,"chipset_id");
    }
}
