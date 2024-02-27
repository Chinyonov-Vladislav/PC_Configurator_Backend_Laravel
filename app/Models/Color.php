<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Color extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function computer_cases(): HasMany
    {
        return $this->hasMany(Computer_case::class, "color_id");
    }

    public function computer_case_fans(): HasMany
    {
        return $this->hasMany(Computer_case_fan::class, "color_id");
    }

    public function cpu_coolers(): HasMany
    {
        return $this->hasMany(cpu_cooler::class, "color_id");
    }

    public function optical_drives(): HasMany
    {
        return $this->hasMany(Optical_drive::class, "color_id");
    }

    public function power_supplies(): HasMany
    {
        return $this->hasMany(Power_supply::class, "color_id");
    }

    public function rams(): HasMany
    {
        return $this->hasMany(Ram::class, "color_id");
    }

    public function sound_cards(): HasMany
    {
        return $this->hasMany(Sound_card::class, "color_id");
    }
    public function graphical_cards(): HasMany
    {
        return $this->hasMany(Graphical_card::class,"color_id");
    }
    public function wired_network_cards(): HasMany
    {
        return $this->hasMany(Wired_network_card::class, "color_id");
    }
}
