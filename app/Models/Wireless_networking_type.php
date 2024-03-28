<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Wireless_networking_type extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function motherboards()
    {
        return $this->hasMany(Motherboard::class, "wireless_networking_type_id");
    }
    public function wifi_cards()
    {
        return $this->hasMany(Wifi_card::class, "protocol_id");
    }
}
