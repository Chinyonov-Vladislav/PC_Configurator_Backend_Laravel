<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Computer_part_wireless_networking_type extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function motherboards(): HasMany
    {
        return  $this->hasMany(Motherboard::class, "wireless_networking_type_id");
    }
}
