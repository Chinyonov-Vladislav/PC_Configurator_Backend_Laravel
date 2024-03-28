<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Computer_part extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function link(): HasOne
    {
        return $this->hasOne(Computer_parts_link::class, "computer_part_id");
    }
    public function part_numbers(): HasMany
    {
        return $this->hasMany(Part_number::class, "computer_part_link_id");
    }

}
