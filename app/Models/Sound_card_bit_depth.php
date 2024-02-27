<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sound_card_bit_depth extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function sound_cards(): HasMany
    {
        return $this->hasMany(Sound_card::class, "sound_card_bit_depth_id");
    }
}
