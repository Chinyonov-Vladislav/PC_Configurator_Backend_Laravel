<?php

namespace App\Models;

use App\Http\Filters\Filterable;
use App\Http\Resources\FullVersionComputerPart\FullVersionGraphicalCardResource;
use App\Interfaces\QueryableAdditionalWithInterface;
use App\Traits\HidePivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use PhpParser\Builder\Interface_;

class Graphical_card extends Model implements QueryableAdditionalWithInterface
{
    use Filterable;
    use HasFactory;
    use HidePivot;
    protected $guarded = [];
    public function manufacturer(): BelongsTo
    {
        return $this->belongsTo(Manufacturer::class, "manufacturer_id");
    }
    public function chipset(): BelongsTo
    {
        return $this->belongsTo(Chipset::class, "chipset_id");
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
        return $this->belongsTo(Computer_interface::class, "interface_id");
    }
    public function sli_crossfire_types(): BelongsToMany
    {
        return $this->belongsToMany(sli_crossfire_type::class, "graphical_card_sli_crossfires",
            "graphical_card_id","sli_crossfire_type_id");
    }
    public function link(): BelongsTo
    {
        return $this->belongsTo(Computer_parts_link::class, "link_id");
    }
    public function ports(): BelongsToMany
    {
        return $this->belongsToMany(Port::class, "graphical_card_ports",
            "graphical_card_id","port_id");
    }
    public function ratings()
    {
        return $this->morphMany(Rating::class, 'ratingable', "ratingable_type","ratingable_id");
    }
    public function checkExistById($id): bool
    {
        return $this::query()->where('id', $id)->exists();
    }
    public function getItemById($id)
    {
        $graphic_card = $this->addWithToQuery($this::query())
            ->where("id",'=',$id)->first();
        /*$this->hidePivotField($graphic_card->sli_crossfire_types);
        $this->hidePivotField($graphic_card->ports);
        $hidden_columns = ["manufacturer_id",
            "chipset_id",
            "color_id",
            "cooling_type_id",
            "external_power_type_id",
            "memory_type_id",
            "frame_sync_type_id",
            "interface_id",
            "link_id",
            "created_at",
            "updated_at"];
        $graphic_card->makeHidden($hidden_columns);*/
        return new FullVersionGraphicalCardResource($graphic_card);
    }

    public static function addWithToQuery($query)
    {
        $query->with([
        "manufacturer"=>function ($query) {
            $query->select(["id","name"]);
        },
        "chipset"=>function ($query) {
            $query->select(["id","name"]);
        },
        "color"=>function ($query) {
            $query->select(["id","name"]);
        },
        "cooling_type"=>function ($query) {
            $query->select(["id","name"]);
        },
            "memory_type"=>function ($query) {
                $query->select(["id","name"]);
            },
        "frame_sync_type"=>function ($query) {
            $query->select(["id","name"]);
        },
        "interface"=>function ($query) {
            $query->select(["id","name"]);
        },
        "sli_crossfire_types"=>function ($query) {
            $query->select(["sli_crossfire_types.id","sli_crossfire_types.name", "sli_crossfire_types.count_graphical_card"]);
        },
        "ports"=>function ($query) {
            $query->select(["ports.id","ports.name","graphical_card_ports.count"]);
        }]);
        return $query;
    }
}
