<?php

namespace App\Models;

use App\Http\Filters\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Motherboard extends Model
{
    use Filterable;
    use HasFactory;
    protected $guarded = [];
    /*public function chipset()
    {
        return $this->hasOneThrough(Chipset::class,Computer_part_chipset::class, "chipset_id","id","id","id");
    }*/
    public function chipset(): BelongsTo
    {
        return $this->belongsTo(Computer_part_chipset::class,"chipset_id");
    }
    public function form_factor(): BelongsTo
    {
        return $this->belongsTo(Computer_part_form_factor::class,"form_factor_id");
    }
    public function manufacturer(): BelongsTo
    {
        return $this->belongsTo(Manufacturer::class,"manufacturer_id");
    }
    public function socket(): BelongsTo
    {
        return $this->belongsTo(Socket::class,"socket_id");
    }
    public function wireless_networking_type(): BelongsTo
    {
        return $this->belongsTo(Computer_part_wireless_networking_type::class,"wireless_networking_type_id");
    }
    public function memory_type(): BelongsTo
    {
        return $this->belongsTo(Type_memory::class,"memory_type_id");
    }
    public function link(): BelongsTo
    {
        return $this->belongsTo(Computer_parts_link::class,"link_id");
    }
    public function m2_slots(): BelongsToMany
    {
        return $this->belongsToMany(m2_slot::class,"motherboard_m2_slots",
            "motherboard_id","m2_slot_id");
    }
    public function frequencies_memory_with_types(): BelongsToMany
    {
        return $this->belongsToMany(Frequencies_memory_with_type::class,"supported_memory_by_motherboards",
            "motherboard_id","frequency_memory_type_id");
    }
    public function onboard_internet_cards(): BelongsToMany
    {
        return $this->belongsToMany(Internet_motherboard::class, "onboard_internet_motherboards",
            "motherboard_id","internet_motherboard_id");
    }
    public function ports(): BelongsToMany
    {
        return $this->belongsToMany(Computer_part_port::class, "motherboard_ports",
            "motherboard_id","computer_port_id");
    }
    public function computer_part_interfaces(): BelongsToMany
    {
        return $this->belongsToMany(Computer_part_interface::class, "motherboard_interfaces",
            "motherboard_id","interface_id");
    }
    public function sli_crossfire_types(): BelongsToMany
    {
        return $this->belongsToMany(sli_crossfire_type::class,"motherboard_sli_crossfire_types",
            "motherboard_id","sli_crossfire_type_id");
    }
}
