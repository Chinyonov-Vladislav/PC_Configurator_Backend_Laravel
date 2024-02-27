<?php

namespace App\Models;

use App\Http\Filters\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Wifi_card extends Model
{
    use HasFactory;
    use Filterable;
    protected $guarded = [];
    public function interface(): BelongsTo
    {
        return $this->belongsTo(Computer_part_interface::class,"interface_id");
    }
    public function manufacturer(): BelongsTo
    {
        return $this->belongsTo(Manufacturer::class,"manufacturer_id");
    }
    public function protocol(): BelongsTo
    {
        return $this->belongsTo(Computer_part_wireless_networking_type::class,"protocol_id");
    }
    public function operating_range(): BelongsTo
    {
        return $this->belongsTo(Operating_range::class,"operating_range_id");
    }
    public function color(): BelongsTo
    {
        return $this->belongsTo(Color::class,"color_id");
    }
    public function antenna(): BelongsTo
    {
        return $this->belongsTo(Wifi_card_antenna::class,"antenna_id");
    }
    public function link(): BelongsTo
    {
        return $this->belongsTo(Computer_parts_link::class,"link_id");
    }
    public function securities()
    {
        return $this->belongsToMany(Security::class,"wifi_card_securities",
            "wifi_card_id","security_id");
    }
}
