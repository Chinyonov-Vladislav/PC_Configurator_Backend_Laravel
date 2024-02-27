<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Led extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function computer_case_fans(): HasMany
    {
        return $this->hasMany(Computer_case_fan::class, "led_id");
    }
}
