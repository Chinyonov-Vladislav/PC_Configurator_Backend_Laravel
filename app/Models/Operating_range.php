<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operating_range extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function wifi_cards()
    {
        return $this->hasMany(Wifi_card::class, "operating_range_id");
    }
}
