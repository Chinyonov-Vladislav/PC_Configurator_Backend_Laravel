<?php

namespace App\Models;

use App\Http\Filters\Filterable;
use App\Http\Resources\FullVersionComputerPart\FullVersionSoundCardResource;
use App\Interfaces\QueryableAdditionalWithInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sound_card extends Model implements QueryableAdditionalWithInterface
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
        return $this->belongsTo(Chipset::class, "chipset_sound_card_id");
    }

    public function channel(): BelongsTo
    {
        return $this->belongsTo(Sound_card_channel::class, "channel_sound_card_id");
    }

    public function interface(): BelongsTo
    {
        return $this->belongsTo(Computer_interface::class, "interface_id");
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
    public function ratings()
    {
        return $this->morphMany(Rating::class, 'ratingable', "ratingable_type","ratingable_id");
    }

    public function checkExistById($id): bool
    {
        return $this::query()->where('id', $id)->exists();
    }

    public function getItemById($id): FullVersionSoundCardResource
    {
        /*$hidden_columns = ["color_id",
            "chipset_sound_card_id",
            "channel_sound_card_id",
            "interface_id",
            "sound_card_bit_depth_id",
            "manufacturer_id",
            "link_id",
            "created_at",
            "updated_at"];*/
        $item = $this->addWithToQuery($this::query())
            ->where("id", "=", $id)
            ->first();
        return new FullVersionSoundCardResource($item);
    }

    public static function addWithToQuery($query)
    {
        $query->with([
            "color" => function ($query) {
                $query->select(["id", "name"]);
            },
            "chipset" => function ($query) {
                $query->select(["id", "name"]);
            },
            "channel" => function ($query) {
                $query->select(["id", "name"]);
            },
            "interface" => function ($query) {
                $query->select(["id", "name"]);
            },
            "sound_card_bit_depth" => function ($query) {
                $query->select(["id", "name"]);
            },
            "manufacturer" => function ($query) {
                $query->select(["id", "name"]);
            },
        ]);
        return $query;
    }
}
