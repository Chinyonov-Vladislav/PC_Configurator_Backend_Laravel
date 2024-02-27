<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Computer_part_form_factor extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function computer_cases(): HasMany
    {
        return $this->hasMany(Computer_case::class, "form_factor_id");
    }
    public function compabilities_form_factor_motherboards_with_cases(): BelongsToMany
    {
        return $this->belongsToMany(Computer_part_form_factor::class, "compatibility_case_with_motherboards",
            "form_factor_id",'computer_case_id');
    }
    public function internal_storage_devices(): HasMany
    {
        return $this->hasMany(Internal_storage_device::class, "form_factor_id");
    }
    public function motherboards(): HasMany
    {
        return  $this->hasMany(Motherboard::class, "form_factor_id");
    }
    public function optical_drives(): HasMany
    {
        return $this->hasMany(Optical_drive::class,"form_factor_id");
    }
    public function power_supplies(): HasMany
    {
        return $this->hasMany(Power_supply::class, "form_factor_id");
    }
    public function rams(): HasMany
    {
        return $this->hasMany(Ram::class,"form_factor_id");
    }
}
