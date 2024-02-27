<?php

namespace App\Models;

use App\Http\Filters\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sound_card extends Model
{
    use HasFactory;
    use Filterable;
    protected $guarded = [];
    public function color(): BelongsTo
    {
        return $this->belongsTo(Color::class, "color_id");
    }
    public function chipset(): BelongsTo
    {
        return $this->belongsTo(Computer_part_chipset::class, "chipset_sound_card_id");
    }
    public function channel(): BelongsTo
    {
        return $this->belongsTo(Sound_card_channel::class, "channel_sound_card_id");
    }
    public function interface(): BelongsTo
    {
        return $this->belongsTo(Computer_part_interface::class, "interface_id");
    }
    public function sound_card_bit_depth(): BelongsTo
    {
        return $this->belongsTo(Sound_card_bit_depth::class, "sound_card_bit_depth_id");
    }
    public function manufacturer(): BelongsTo
    {
        return $this->belongsTo(Manufacturer::class, "manufacturer_id");
    }
    public function link(): BelongsTo
    {
        return $this->belongsTo(Computer_parts_link::class, "link_id");
    }
}
