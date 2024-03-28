<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wifi_card_antenna extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function wifi_cards()
    {
        return $this->hasMany(Wifi_card::class,"antenna_id");
    }
}
