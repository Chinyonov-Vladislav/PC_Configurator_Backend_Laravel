<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Computer_case_fan extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function manufacturer(): BelongsTo
    {
        return $this->belongsTo(Manufacturer::class,"manufacturer_id");
    }
    public function color(): BelongsTo
    {
        return $this->belongsTo(Color::class,"color_id");
    }
    public function connector(): BelongsTo
    {
        return $this->belongsTo(Computer_part_connector::class,"connector_id");
    }
    public function controller(): BelongsTo
    {
        return $this->belongsTo(Computer_part_controller::class,"controller_id");
    }
    public function led(): BelongsTo
    {
        return $this->belongsTo(Led::class,"led_id");
    }
    public function bearing_type(): BelongsTo
    {
        return $this->belongsTo(Computer_part_bearing_type::class,"bearing_type_id");
    }
    public function link(): BelongsTo
    {
        return $this->belongsTo(Computer_parts_link::class,"link_id");
    }
}
