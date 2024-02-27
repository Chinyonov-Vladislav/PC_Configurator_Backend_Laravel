<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Computer_case extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function color(): BelongsTo
    {
        return $this->belongsTo(Color::class, 'color_id');
    }
    public function manufacturer(): BelongsTo
    {
        return $this->belongsTo(Manufacturer::class, 'manufacturer_id');
    }
    public function side_panel(): BelongsTo
    {
        return $this->belongsTo(Side_panel::class, 'side_panel_id');
    }
    public function form_factor(): BelongsTo
    {
        return $this->belongsTo(Computer_part_form_factor::class, 'form_factor_id');
    }
    public function link(): BelongsTo
    {
        return $this->belongsTo(Computer_parts_link::class, 'link_id');
    }
    public function computer_part_form_factors(): BelongsToMany
    {
        return $this->belongsToMany(Computer_part_form_factor::class, "compatibility_case_with_motherboards",
            "computer_case_id","form_factor_id");
    }
    public function compatibility_with_videocard_types(): BelongsToMany
    {
        return $this->belongsToMany(Compatibility_with_videocard_type::class, "compatibility_case_with_videocards",
            "computer_case_id","compatibility_with_videocard_type_id");
    }
    public function computer_part_ports(): BelongsToMany
    {
        return $this->belongsToMany(Computer_part_port::class, "computer_case_ports","computer_case_id","computer_port_id");
    }
    public function computer_part_expansion_slots(): BelongsToMany
    {
        return $this->belongsToMany(Computer_part_expansion_slot::class, "computer_case_expansion_slots",
            "computer_case_id","expansion_slot_id");
    }
    public function drive_bays(): BelongsToMany
    {
        return $this->belongsToMany(Drive_bay::class,"computer_case_drive_bays",
            "computer_case_id","drive_bay_id");
    }
    public function cpu_coolers(): BelongsToMany
    {
        return $this->belongsToMany(cpu_cooler::class, "Compatibility_cpu_cooler_pc_cases",
            "pc_case_id","cpu_cooler_id");
    }
}
