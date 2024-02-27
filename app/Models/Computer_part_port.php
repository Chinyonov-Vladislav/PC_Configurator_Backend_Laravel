<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Computer_part_port extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function computer_cases(): BelongsToMany
    {
        return $this->belongsToMany(Computer_case::class, "computer_case_ports", "computer_port_id", "computer_case_id");
    }

    public function motherboards(): BelongsToMany
    {
        return $this->belongsToMany(Motherboard::class, "motherboard_ports",
            "computer_port_id","motherboard_id");
    }
    public function graphical_cards(): BelongsToMany
    {
        return $this->belongsToMany(Graphical_card::class, "graphical_card_ports",
            "port_id","graphical_card_id");
    }
}
