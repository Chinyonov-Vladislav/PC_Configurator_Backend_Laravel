<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Core_family extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function CPUs(): HasMany
    {
        return $this->hasMany(cpu::class,"core_family_id");
    }
}
