<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Frequencies_memory_with_type extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function type_memory(): BelongsTo
    {
        return $this->belongsTo(Type_memory::class, "type_memory_id");
    }
    public function motherboards(): BelongsToMany
    {
        return $this->belongsToMany(Motherboard::class,"supported_memory_by_motherboards",
            "frequency_memory_type_id","motherboard_id");
    }
    public function rams(): HasMany
    {
        return $this->hasMany(Ram::class,"speed_ram_id");
    }
}
