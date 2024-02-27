<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Type_memory extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function frequencies_memory_with_type(): HasMany
    {
        return $this->hasMany(Frequencies_memory_with_type::class,"type_memory_id");
    }
    public function motherboards(): HasMany
    {
        return  $this->hasMany(Motherboard::class, "memory_type_id");
    }
}
