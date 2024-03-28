<?php

namespace App\Models;

use App\Http\Filters\Filterable;
use App\Http\Resources\FullVersionComputerPart\FullVersionCpuCoolerResource;
use App\Interfaces\QueryableAdditionalWithInterface;
use App\Traits\HidePivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class cpu_cooler extends Model implements QueryableAdditionalWithInterface
{
    use HasFactory;
    use Filterable;
    use HidePivot;
    protected $guarded = [];
    protected $casts = [
        'fanless' => 'boolean',
        'water_cooled' => 'boolean'
    ];
    public function color(): BelongsTo
    {
        return $this->belongsTo(Color::class, "color_id");
    }
    public function manufacturer(): BelongsTo
    {
        return $this->belongsTo(Manufacturer::class, "manufacturer_id");
    }
    public function bearing_type(): BelongsTo
    {
        return $this->belongsTo(Bearing_type::class, "bearing_type_id");
    }
    public function link(): BelongsTo
    {
        return $this->belongsTo(Computer_parts_link::class, "link_id");
    }
    public function pc_cases(): BelongsToMany
    {
        return $this->belongsToMany(Computer_case::class,"Compatibility_cpu_cooler_pc_cases",
            "cpu_cooler_id","pc_case_id");
    }
    public function sockets(): BelongsToMany
    {
        return $this->belongsToMany(Socket::class, "cpu_cooler_cpu_sockets",
            "cpu_cooler_id","socket_id");
    }
    public function ratings()
    {
        return $this->morphMany(Rating::class, 'ratingable', "ratingable_type","ratingable_id");
    }
    public function checkExistById($id): bool
    {
        return $this::query()->where('id', $id)->exists();
    }
    public function getItemById($id): FullVersionCpuCoolerResource
    {
        $cpu_cooler = $this->addWithToQuery($this::query())
            ->where("id", "=", $id)
            ->first();
        //$this->hidePivotField($cpu_cooler->sockets);
        //$hidden_columns = ["color_id","manufacturer_id","bearing_type_id","link_id","created_at", "updated_at"];
        //$cpu_cooler->makeHidden($hidden_columns);
        return new FullVersionCpuCoolerResource($cpu_cooler);
    }

    public static function addWithToQuery($query)
    {
        $query->with([
        "color"=>function ($query) {
            $query->select(["id","name"]);
        },
        "manufacturer"=>function ($query) {
            $query->select(["manufacturers.id","manufacturers.name"]);
        },
        "bearing_type"=>function ($query)
        {
            $query->select(["id","name"]);
        },
        "sockets"=>function ($query) {
            $query->select(["sockets.id","sockets.name"]);
        }]);
        return $query;
    }
}
