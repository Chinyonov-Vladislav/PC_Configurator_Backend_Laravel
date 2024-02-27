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

    public function bearing_types(): BelongsToMany
    {
        return $this->belongsToMany(Bearing_type::class, "computer_part_bearing_types",
            "computer_part_id", 'bearing_type_id');
    }

    public function link(): HasOne
    {
        return $this->hasOne(Computer_parts_link::class, "computer_part_id");
    }

    public function part_numbers(): HasMany
    {
        return $this->hasMany(Part_number::class, "computer_part_link_id");
    }

    public function form_factors(): BelongsToMany
    {
        return $this->belongsToMany(Form_factor::class, "computer_part_form_factors",
            'computer_part_id', 'form_factor_id');
    }

    public function computer_interfaces(): BelongsToMany
    {
        return $this->belongsToMany(Computer_interface::class, 'computer_part_interfaces',
            'computer_part_id', 'computer_interface_id');
    }

    public function chipsets(): BelongsToMany
    {
        return $this->belongsToMany(Chipset::class, "computer_part_chipsets",
            "computer_part_id", "chipset_id");
    }

    public function ports(): BelongsToMany
    {
        return $this->belongsToMany(Port::class, "computer_part_ports",
            "computer_part_id", "port_id");
    }

    public function expansion_slots(): BelongsToMany
    {
        return $this->belongsToMany(Expansion_slot::class, "computer_part_expansion_slots",
            "computer_part_id", "expansion_slot_id");
    }

    public function connectors(): BelongsToMany
    {
        return $this->belongsToMany(Connector::class,"computer_part_connectors",
            "computer_part_id","connector_id");
    }
    public function controllers(): BelongsToMany
    {
        return $this->belongsToMany(Controller::class,"computer_part_controllers",
            "computer_part_id","controller_id");
    }
    public function wireless_networking_types(): BelongsToMany
    {
        return $this->belongsToMany(Wireless_networking_type::class,"computer_part_wireless_networking_types",
            "computer_part_id","wireless_networking_type_id");
    }
}
