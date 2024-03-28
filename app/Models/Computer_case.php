<?php

namespace App\Models;

use App\Http\Filters\Filterable;
use App\Http\Resources\FullVersionComputerPart\FullVersionCaseFanResource;
use App\Http\Resources\FullVersionComputerPart\FullVersionComputerCaseResource;
use App\Interfaces\QueryableAdditionalWithInterface;
use App\Traits\HidePivot;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Computer_case extends Model implements QueryableAdditionalWithInterface
{
    use HidePivot;
    use HasFactory;
    use Filterable;

    protected $guarded = [];

    public function color(): BelongsTo
    {
        return $this->belongsTo(Color::class, 'color_id');
    }

    public function manufacturer(): BelongsTo
    {
        return $this->belongsTo(Manufacturer::class, 'manufacturer_id');
    }

    public function side_panel(): BelongsTo
    {
        return $this->belongsTo(Side_panel::class, 'side_panel_id');
    }

    public function form_factor(): BelongsTo
    {
        return $this->belongsTo(Form_factor::class, 'form_factor_id');
    }

    public function link(): BelongsTo
    {
        return $this->belongsTo(Computer_parts_link::class, 'link_id');
    }

    public function compatibility_with_videocard_types(): BelongsToMany
    {
        return $this->belongsToMany(Compatibility_with_videocard_type::class, "compatibility_case_with_videocards",
            "computer_case_id", "compatibility_with_videocard_type_id");
    }

    public function compatibility_with_videocard_without_type(): HasOne
    {
        return $this->hasOne(Compatibility_case_with_videocard::class, "computer_case_id")
            ->whereNull("compatibility_with_videocard_type_id");
    }

    public function ports(): BelongsToMany
    {
        return $this->belongsToMany(Port::class, "computer_case_ports",
            "computer_case_id", "computer_port_id");
    }

    public function expansion_slots(): BelongsToMany
    {
        return $this->belongsToMany(Expansion_slot::class, "computer_case_expansion_slots",
            "computer_case_id", "expansion_slot_id");
    }

    public function drive_bays(): BelongsToMany
    {
        return $this->belongsToMany(Drive_bay::class, "computer_case_drive_bays",
            "computer_case_id", "drive_bay_id");
    }

    public function cpu_coolers(): BelongsToMany
    {
        return $this->belongsToMany(cpu_cooler::class, "Compatibility_cpu_cooler_pc_cases",
            "pc_case_id", "cpu_cooler_id");
    }

    public function ratings()
    {
        return $this->morphMany(Rating::class, 'ratingable', "ratingable_type","ratingable_id");
    }

    public function checkExistById($id): bool
    {
        return $this::query()->where('id', $id)->exists();
    }

    public function getItemById($id): FullVersionComputerCaseResource
    {
        $computer_case = $this->addWithToQuery($this::query())
            ->where("id", "=", $id)
            ->first();
        /*$this->hidePivotField($computer_case->compatibility_with_videocard_types);
        $this->hidePivotField($computer_case->ports);
        $this->hidePivotField($computer_case->expansion_slots);
        $this->hidePivotField($computer_case->drive_bays);
        if($computer_case->compatibility_with_videocard_without_type !== null)
        {
            $computer_case->compatibility_with_videocard_without_type->makeHidden("computer_case_id");
        }
        //$computer_case->makeHidden("compatibility_with_videocard_without_type.computer_case_id");
        $hidden_columns = ["color_id","manufacturer_id","side_panel_id","form_factor_id","link_id","created_at","updated_at"];
        $computer_case->makeHidden($hidden_columns);*/
        return new FullVersionComputerCaseResource($computer_case);
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
            "side_panel" => function ($query) {
                $query->select(["id", "name"]);
            },
            "form_factor" => function ($query) {
                $query->select(["id", "name"]);
            },
            "compatibility_with_videocard_types" => function ($query) {
                $query->select([
                    //"compatibility_case_with_videocards.id as id_row_compatibility_case_with_videocard",
                    //"compatibility_with_videocard_types.id as id_type_compatibility",
                    "compatibility_case_with_videocards.compatibility_with_videocard_type_id",
                    "name",
                    "compatibility_case_with_videocards.maximum_length_videocard_in_mm"]);
            },
            "compatibility_with_videocard_without_type" => function ($query) {
                $query->select([
                    //"compatibility_case_with_videocards.id as id_row_compatibility_case_with_videocard",
                    "compatibility_case_with_videocards.compatibility_with_videocard_type_id",
                    "compatibility_case_with_videocards.computer_case_id",
                    "compatibility_case_with_videocards.maximum_length_videocard_in_mm"
                ]);
            },
            "ports" => function ($query) {
                $query->select(["ports.id",
                    "ports.name"]);
            },
            "expansion_slots" => function ($query) {
                $query->select([
                    "expansion_slots.id",
                    "name",
                    "computer_case_expansion_slots.count"]);
            },
            "drive_bays" => function ($query) {
                $query->select([
                    "drive_bays.id",
                    "drive_bays.name",
                    "computer_case_drive_bays.count"]);
            }]);
        return $query;
    }

}
