<?php

namespace App\Models;

use App\Http\Filters\Filterable;
use App\Http\Resources\FullVersionComputerPart\FullVersionWiredNetworkCardResource;
use App\Interfaces\QueryableAdditionalWithInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Wired_network_card extends Model implements QueryableAdditionalWithInterface
{
    use HasFactory;
    use Filterable;
    protected $guarded = [];
    public function manufacturer(): BelongsTo
    {
        return $this->belongsTo(Manufacturer::class,"manufacturer_id");
    }
    public function color(): BelongsTo
    {
        return $this->belongsTo(Color::class,"color_id");
    }
    public function interface(): BelongsTo
    {
        return $this->belongsTo(Computer_interface::class,"interface_id");
    }
    public function link(): BelongsTo
    {
        return $this->belongsTo(Computer_parts_link::class,"link_id");
    }
    public function ratings()
    {
        return $this->morphMany(Rating::class, 'ratingable', "ratingable_type","ratingable_id");
    }
    public function checkExistById($id): bool
    {
        return $this::query()->where('id', $id)->exists();
    }
    public function getItemById($id): FullVersionWiredNetworkCardResource
    {
        /*$hidden_columns = ["manufacturer_id",
            "color_id",
            "interface_id",
            "link_id",
            "created_at",
            "updated_at"];*/
        $item = $this->addWithToQuery($this::query())->where("id", "=", $id)->first();
        return new FullVersionWiredNetworkCardResource($item);
    }

    public static function addWithToQuery($query)
    {
        $query->with([
            "manufacturer"=>function ($query) {
                $query->select(["id", "name"]);
            },
            "color"=>function ($query) {
                $query->select(["id", "name"]);
            },
            "interface"=>function ($query) {
                $query->select(["id", "name"]);
            },
        ]);
        return $query;
    }
}
