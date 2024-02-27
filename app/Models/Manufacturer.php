<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Manufacturer extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function computer_cases(): HasMany
    {
        return $this->hasMany(Computer_case::class, "manufacturer_id");
    }
    public function computer_case_fans(): HasMany
    {
        return $this->hasMany(Computer_case_fan::class, "manufacturer_id");
    }
    public function cpu_coolers(): HasMany
    {
        return $this->hasMany(cpu_cooler::class, "manufacturer_id");
    }
    public function CPUs(): HasMany
    {
        return $this->hasMany(cpu::class,"manufacturer_id");
    }
    public function internal_storage_devices(): HasMany
    {
        return $this->hasMany(Internal_storage_device::class, "manufacturer_id");
    }
    public function motherboard_internet_cards(): HasMany
    {
        return $this->hasMany(Internet_motherboard::class, "manufacturer_id");
    }
    public function motherboards(): HasMany
    {
        return  $this->hasMany(Motherboard::class, "manufacturer_id");
    }
    public function optical_drives(): HasMany
    {
        return $this->hasMany(Optical_drive::class,"manufacturer_id");
    }
    public function power_supplies(): HasMany
    {
        return $this->hasMany(Power_supply::class, "manufacturer_id");
    }
    public function rams(): HasMany
    {
        return $this->hasMany(Ram::class,"manufacturer_id");
    }
    public function sound_cards(): HasMany
    {
        return $this->hasMany(Sound_card::class, "manufacturer_id");
    }
    public function graphical_cards(): HasMany
    {
        return $this->hasMany(Graphical_card::class,"manufacturer_id");
    }
    public function wired_network_cards(): HasMany
    {
        return $this->hasMany(Wired_network_card::class, "manufacturer_id");
    }
    public function wifi_cards(): HasMany
    {
        return $this->hasMany(Wifi_card::class, "manufacturer_id");
    }
}
