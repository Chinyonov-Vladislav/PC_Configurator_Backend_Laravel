<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Computer_part_bearing_type extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function computer_case_fans(): HasMany
    {
        return $this->hasMany(Computer_case_fan::class, "bearing_type_id");
    }
    public function cpu_coolers(): HasMany
    {
        return $this->hasMany(cpu_cooler::class, "bearing_type_id");
    }
}
