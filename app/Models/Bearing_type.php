<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Bearing_type extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function computer_parts(): BelongsToMany
    {
        return $this->belongsToMany(Computer_part::class, "computer_part_bearing_types", "bearing_type_id", "computer_part_id");
    }
}
