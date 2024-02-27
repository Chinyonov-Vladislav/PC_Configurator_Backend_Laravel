<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Integrated_graphic extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function CPUs(): HasMany
    {
        return $this->hasMany(cpu::class,"integrated_graphic_id");
    }
}
