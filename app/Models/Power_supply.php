<?php

namespace App\Models;

use App\Http\Filters\Filterable;
use App\Http\Resources\FullVersionComputerPart\FullVersionPowerSupplyResource;
use App\Interfaces\QueryableAdditionalWithInterface;
use App\Traits\HidePivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Power_supply extends Model implements QueryableAdditionalWithInterface
{
    use HasFactory;
    use Filterable;
    use HidePivot;

    protected $guarded = [];

    protected $casts = [
        "fanless"=>"boolean"
    ];
    public function color(): BelongsTo
    {
        return $this->belongsTo(Color::class, "color_id");
    }

    public function manufacturer(): BelongsTo
    {
        return $this->belongsTo(Manufacturer::class, "manufacturer_id");
    }

    public function efficiency_rating(): BelongsTo
    {
        return $this->belongsTo(Efficiency_rating::class, "efficiency_rating_id");
    }

    public function modular_type(): BelongsTo
    {
        return $this->belongsTo(Modular_power_supply_type::class, "modular_type_id");
    }

    public function form_factor(): BelongsTo
    {
        return $this->belongsTo(Form_factor::class, "form_factor_id");
    }

    public function link(): BelongsTo
    {
        return $this->belongsTo(Computer_parts_link::class, "link_id");
    }

    public function outputs(): BelongsToMany
    {
        return $this->belongsToMany(Output_power_supply_type::class, "power_supply_outputs",
            "output_type_id", "power_supply_id");
    }

    public function connectors(): BelongsToMany
    {
        return $this->belongsToMany(Connector::class, "power_supply_connectors",
            "power_supply_id", "connector_id");
    }

    public function ratings()
    {
        return $this->morphMany(Rating::class, 'ratingable', "ratingable_type","ratingable_id");
    }
    public function checkExistById($id): bool
    {
        return $this::query()->where('id', $id)->exists();
    }

    public function getItemById($id): FullVersionPowerSupplyResource
    {
        $power_supply = $this->addWithToQuery($this::query())
            ->where("id",'=',$id)->first();
        /*$this->hidePivotField($power_supply->outputs);
        $this->hidePivotField($power_supply->connectors);
        $hidden_columns = ["color_id",
            "manufacturer_id",
            "efficiency_rating_id",
            "modular_type_id",
            "form_factor_id",
            "link_id",
            "created_at",
            "updated_at"];
        $power_supply->makeHidden($hidden_columns);*/
        return new FullVersionPowerSupplyResource($power_supply);
    }

    public static function addWithToQuery($query)
    {
        $query->with([
            "color" => function ($query) {
                $query->select(["id", "name"]);
            },
            "manufacturer" => function ($query) {
                $query->select(["id", "name"]);
            },
            "efficiency_rating" => function ($query) {
                $query->select(["id", "name"]);
            },
            "modular_type" => function ($query) {
                $query->select(["id", "name"]);
            },
            "form_factor" => function ($query) {
                $query->select(["id", "name"]);
            },
            "outputs" => function ($query) {
                $query->select(["output_power_supply_types.id", "output_power_supply_types.name"]);
            },
            "connectors" => function ($query) {
                $query->select(["connectors.id", "connectors.name", "power_supply_connectors.count"]);
            },
        ]);
        return $query;
    }
}
