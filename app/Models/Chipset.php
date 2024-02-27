<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Chipset extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function computer_parts(): BelongsToMany
    {
        return $this->belongsToMany(Chipset::class, "computer_part_chipsets","chipset_id","computer_part_id");
    }
}
