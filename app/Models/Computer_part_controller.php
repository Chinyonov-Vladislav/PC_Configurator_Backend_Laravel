<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Computer_part_controller extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function computer_case_fans(): HasMany
    {
        return $this->hasMany(Computer_case_fan::class, "controller_id");
    }
    public function internal_storage_devices(): HasMany
    {
        return $this->hasMany(Internal_storage_device::class, "ssd_controller_id");
    }
}
