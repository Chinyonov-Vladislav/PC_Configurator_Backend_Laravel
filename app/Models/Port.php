<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Port extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function computer_parts():BelongsToMany
    {
        return $this->belongsToMany(Graphical_card::class, "computer_part_ports",
            "port_id","computer_part_id");
    }
}
