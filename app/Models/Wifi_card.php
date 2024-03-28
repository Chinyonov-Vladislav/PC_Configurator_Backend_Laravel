<?php

namespace App\Models;

use App\Http\Filters\Filterable;
use App\Http\Resources\FullVersionComputerPart\FullVersionWifiCardResource;
use App\Interfaces\QueryableAdditionalWithInterface;
use App\Traits\HidePivot;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Wifi_card extends Model implements QueryableAdditionalWithInterface
{
    use HasFactory;
    use Filterable;
    use HidePivot;

    protected $guarded = [];

    public function interface(): BelongsTo
    {
        return $this->belongsTo(Computer_interface::class, "interface_id");
    }

    public function manufacturer(): BelongsTo
    {
        return $this->belongsTo(Manufacturer::class, "manufacturer_id");
    }

    public function protocol(): BelongsTo
    {
        return $this->belongsTo(Wireless_networking_type::class, "protocol_id");
    }

    public function operating_range(): BelongsTo
    {
        return $this->belongsTo(Operating_range::class, "operating_range_id");
    }

    public function color(): BelongsTo
    {
        return $this->belongsTo(Color::class, "color_id");
    }

    public function antenna(): BelongsTo
    {
        return $this->belongsTo(Wifi_card_antenna::class, "antenna_id");
    }

    public function link(): BelongsTo
    {
        return $this->belongsTo(Computer_parts_link::class, "link_id");
    }

    public function securities(): BelongsToMany
    {
        return $this->belongsToMany(Security::class, "wifi_card_securities",
            "wifi_card_id", "security_id");
    }
    public function ratings()
    {
        return $this->morphMany(Rating::class, 'ratingable', "ratingable_type","ratingable_id");
    }
    public function checkExistById($id): bool
    {
        return $this::query()->where('id', $id)->exists();
    }


    public function getItemById($id): FullVersionWifiCardResource
    {
        $wifi_card = $this->addWithToQuery($this::query())->where("id", "=", $id)->first();
        /*$this->hidePivotField($wifi_card->securities);
        $hidden_columns = ["interface_id",
            "manufacturer_id",
            "protocol_id",
            "operating_range_id",
            "color_id",
            "antenna_id",
            "link_id",
            "created_at",
            "updated_at"];
        $wifi_card->makeHidden($hidden_columns);*/
        return new FullVersionWifiCardResource($wifi_card);
    }

    public static function addWithToQuery($query)
    {
        $query->with([
            "interface" => function ($query) {
                $query->select(["id", "name"]);
            },
            "manufacturer" => function ($query) {
                $query->select(["id", "name"]);
            },
            "protocol" => function ($query) {
                $query->select(["id", "name"]);
            },
            "operating_range" => function ($query) {
                $query->select(["id", "name"]);
            },
            "color" => function ($query) {
                $query->select(["id", "name"]);
            },
            "antenna" => function ($query) {
                $query->select(["id", "name"]);
            },
            "securities" => function ($query) {
                $query->select(["securities.id", "securities.name"]);
            }
        ]);
        return $query;
    }
}
