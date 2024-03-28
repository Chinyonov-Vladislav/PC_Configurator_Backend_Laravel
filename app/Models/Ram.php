<?php

namespace App\Models;

use App\Http\Filters\Filterable;
use App\Http\Resources\FullVersionComputerPart\FullVersionRamResource;
use App\Interfaces\QueryableAdditionalWithInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ram extends Model implements QueryableAdditionalWithInterface
{
    use HasFactory;
    use Filterable;

    protected $guarded = [];

    protected $casts = [
        "heat_spreader"=>"boolean"
    ];
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
        return $this->belongsTo(Form_factor::class, "form_factor_id");
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

    public function ratings()
    {
        return $this->morphMany(Rating::class, 'ratingable', "ratingable_type","ratingable_id");
    }

    public function checkExistById($id): bool
    {
        return $this::query()->where('id', $id)->exists();
    }

    public function getItemById($id): FullVersionRamResource
    {
        $ram = $this->addWithToQuery($this::query())
            ->where("id", "=", $id)
            ->first();
        /*$ram->speed->makeHidden("type_memory_id");
        $hidden_columns = ["color_id",
            "manufacturer_id",
            "form_factor_id",
            "module_id",
            "timing_id",
            "speed_ram_id",
            "ecc_registered_type_id",
            "link_id",
            "created_at",
            "updated_at"];
        $ram->makeHidden($hidden_columns);*/
        return new FullVersionRamResource($ram);
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
            "form_factor" => function ($query) {
                $query->select(["id", "name"]);
            },
            "module" => function ($query) {
                $query->select(["id", "count", "capacity_one_ram_mb"]);
            },
            "timing" => function ($query) {
                $query->select(["id", "name"]);
            },
            "speed" => function ($query) {
                $query->with(["type_memory" => function ($query) {
                    $query->select(["type_memories.id", "type_memories.name"]);
                }])->select(["frequencies_memory_with_types.id", "frequencies_memory_with_types.frequency_mhz", "frequencies_memory_with_types.type_memory_id"]);
            },
            "ecc_registered_type" => function ($query) {
                $query->select(["id", "name"]);
            },
        ]);
        return $query;
    }
}
