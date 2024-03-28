<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Form_factor extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function computer_cases(): HasMany
    {
        return $this->hasMany(Computer_case::class, "form_factor_id");
    }
    public function storage_devices(): HasMany
    {
        return $this->hasMany(Internal_storage_device::class, "form_factor_id");
    }
    public function motherboards(): HasMany
    {
        return $this->hasMany(Motherboard::class, "form_factor_id");
    }
    public function optical_drives(): HasMany
    {
        return $this->hasMany(Optical_drive::class, "form_factor_id");
    }
    public function power_supplies(): HasMany
    {
        return $this->hasMany(Power_supply::class,"form_factor_id");
    }
    public function ram(): HasMany
    {
        return $this->hasMany(Ram::class, "form_factor_id");
    }
}
