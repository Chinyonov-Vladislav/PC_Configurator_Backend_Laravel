<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Security extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function wifi_cards(): BelongsToMany
    {
        return $this->belongsToMany(Wifi_card::class,"wifi_card_securities",
            "security_id","wifi_card_id");
    }
}
