<?php

namespace App\Models;

use App\Http\Filters\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Optical_drive extends Model
{
    use Filterable;
    use HasFactory;
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
    public function interface(): BelongsTo
    {
        return $this->belongsTo(Computer_part_interface::class, "interface_id");
    }
    public function link(): BelongsTo
    {
        return $this->belongsTo(Computer_parts_link::class, "link_id");
    }
}
