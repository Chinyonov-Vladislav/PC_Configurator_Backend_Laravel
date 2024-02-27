<?php

namespace App\Models;

use App\Http\Filters\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Graphical_card extends Model
{
    use Filterable;
    use HasFactory;
    protected $guarded = [];
    public function manufacturer(): BelongsTo
    {
        return $this->belongsTo(Manufacturer::class, "manufacturer_id");
    }
    public function chipset(): BelongsTo
    {
        return $this->belongsTo(Computer_part_chipset::class, "chipset_id");
    }
    public function color(): BelongsTo
    {
        return $this->belongsTo(Color::class, "color_id");
    }
    public function cooling_type(): BelongsTo
    {
        return $this->belongsTo(Cooling_type::class, "cooling_type_id");
    }
    public function external_power_type(): BelongsTo
    {
        return $this->belongsTo(Graphical_card_external_power_type::class, "external_power_type_id");
    }
    public function memory_type(): BelongsTo
    {
        return $this->belongsTo(Graphical_card_memory_type::class, "memory_type_id");
    }
    public function frame_sync_type(): BelongsTo
    {
        return $this->belongsTo(Frame_sync_type::class, "frame_sync_type_id");
    }
    public function interface(): BelongsTo
    {
        return $this->belongsTo(Computer_part_interface::class, "interface_id");
    }
    public function sli_crossfire_type(): BelongsTo
    {
        return $this->belongsTo(sli_crossfire_type::class, "sli_crossfire_type_id");
    }
    public function link(): BelongsTo
    {
        return $this->belongsTo(Computer_parts_link::class, "link_id");
    }
    public function ports(): BelongsToMany
    {
        return $this->belongsToMany(Computer_part_port::class, "graphical_card_ports",
            "graphical_card_id","port_id");
    }
}
