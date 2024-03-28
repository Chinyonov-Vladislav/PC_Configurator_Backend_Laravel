<?php

namespace App\Models;

use App\Http\Filters\Filterable;
use App\Http\Resources\FullVersionComputerPart\FullVersionCpuResource;
use App\Interfaces\QueryableAdditionalWithInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class cpu extends Model implements QueryableAdditionalWithInterface
{
    use Filterable;
    use HasFactory;

    protected $guarded = [];
    protected $casts = [
        'includes_cooler' => 'boolean',
        'ecc_support' => 'boolean',
        "multithreading"=>'boolean',
        "includes_cpu_cooler"=>'boolean',
        "SMT"=>'boolean'
    ];

    public function manufacturer(): BelongsTo
    {
        return $this->belongsTo(Manufacturer::class, "manufacturer_id");
    }

    public function core_family(): BelongsTo
    {
        return $this->belongsTo(Core_family::class, "core_family_id");
    }

    public function integrated_graphic(): BelongsTo
    {
        return $this->belongsTo(Integrated_graphic::class, "integrated_graphic_id");
    }

    public function microarchitecture(): BelongsTo
    {
        return $this->belongsTo(Microarchitecture::class, "microarchitecture_id");
    }

    public function packaging(): BelongsTo
    {
        return $this->belongsTo(Packaging::class, "packaging_id");
    }

    public function series(): BelongsTo
    {
        return $this->belongsTo(Series::class, "series_id");
    }

    public function socket(): BelongsTo
    {
        return $this->belongsTo(Socket::class, "socket_id");
    }

    public function link(): BelongsTo
    {
        return $this->belongsTo(Computer_parts_link::class, "link_id");
    }

    public function checkExistById($id): bool
    {
        return $this::query()->where('id', $id)->exists();
    }

    public function ratings()
    {
        return $this->morphMany(Rating::class, 'ratingable', "ratingable_type","ratingable_id");
    }
    public function getItemById($id)
    {
        /*$hidden_columns = ["manufacturer_id",
            "core_family_id",
            "integrated_graphic_id",
            "microarchitecture_id",
            "packaging_id",
            "series_id",
            "socket_id",
            "link_id",
            "created_at",
            "updated_at"];*/
        $item = $this->addWithToQuery($this::query())->where("id", "=", $id)->first();
        return new FullVersionCpuResource($item);
    }

    public static function addWithToQuery($query)
    {
        $query->with([
            "manufacturer" => function ($query) {
                $query->select(["id", "name"]);
            },
            "core_family" => function ($query) {
                $query->select(["id", "name"]);
            },
            "integrated_graphic" => function ($query) {
                $query->select(["id", "name"]);
            },
            "microarchitecture" => function ($query) {
                $query->select(["id", "name"]);
            },
            "packaging" => function ($query) {
                $query->select(["id", "name"]);
            },
            "series" => function ($query) {
                $query->select(["id", "name"]);
            },
            "socket" => function ($query) {
                $query->select(["id", "name"]);
            }
        ]);
        return $query;
    }
}
