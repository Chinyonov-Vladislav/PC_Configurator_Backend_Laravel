<?php

namespace App\Models;

use App\Http\Filters\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ram extends Model
{
    use HasFactory;
    use Filterable;
    protected $guarded = [];
    public function color(): BelongsTo
    {
        return $this->belongsTo(Color::class, "color_id");
    }
    public function manufacturer(): BelongsTo
    {
        return $this->belongsTo(Manufacturer::class, "manufacturer_id");
    }
    public function form_factor(): BelongsTo
    {
        return $this->belongsTo(Computer_part_form_factor::class, "form_factor_id");
    }
    public function module(): BelongsTo
    {
        return $this->belongsTo(Ram_module::class, "module_id");
    }
    public function timing(): BelongsTo
    {
        return $this->belongsTo(Ram_timing::class, "timing_id");
    }
    public function speed(): BelongsTo
    {
        return $this->belongsTo(Frequencies_memory_with_type::class, "speed_ram_id");
    }
    public function ecc_registered_type(): BelongsTo
    {
        return $this->belongsTo(Ram_ecc_registered_type::class, "ecc_registered_type_id");
    }
    public function link(): BelongsTo
    {
        return $this->belongsTo(Computer_parts_link::class, "link_id");
    }
}
