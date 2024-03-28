<?php

namespace App\Models;

use App\Http\Filters\Filterable;
use App\Http\Resources\FullVersionComputerPart\FullVersionMotherboardResource;
use App\Interfaces\QueryableAdditionalWithInterface;
use App\Traits\HidePivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Motherboard extends Model implements QueryableAdditionalWithInterface
{
    use Filterable;
    use HasFactory;
    use HidePivot;

    protected $guarded = [];
    protected $casts = [
      "onboard_video"=>"boolean",
      "support_ecc"=>"boolean",
      "raid_support"=>"boolean",
    ];

    /*public function chipset()
    {
        return $this->hasOneThrough(Chipset::class,Computer_part_chipset::class, "chipset_id","id","id","id");
    }*/
    public function chipset(): BelongsTo
    {
        return $this->belongsTo(Chipset::class, "chipset_id");
    }

    public function form_factor(): BelongsTo
    {
        return $this->belongsTo(Form_factor::class, "form_factor_id");
    }

    public function manufacturer(): BelongsTo
    {
        return $this->belongsTo(Manufacturer::class, "manufacturer_id");
    }

    public function socket(): BelongsTo
    {
        return $this->belongsTo(Socket::class, "socket_id");
    }

    public function wireless_networking_type(): BelongsTo
    {
        return $this->belongsTo(Wireless_networking_type::class, "wireless_networking_type_id");
    }

    public function memory_type(): BelongsTo
    {
        return $this->belongsTo(Type_memory::class, "memory_type_id");
    }

    public function link(): BelongsTo
    {
        return $this->belongsTo(Computer_parts_link::class, "link_id");
    }

    public function m2_slots(): BelongsToMany
    {
        return $this->belongsToMany(m2_slot::class, "motherboard_m2_slots",
            "motherboard_id", "m2_slot_id");
    }

    public function frequencies_memory_with_types(): BelongsToMany
    {
        return $this->belongsToMany(Frequencies_memory_with_type::class, "supported_memory_by_motherboards",
            "motherboard_id", "frequency_memory_type_id");
    }

    public function onboard_internet_cards(): BelongsToMany
    {
        return $this->belongsToMany(Internet_motherboard::class, "onboard_internet_motherboards",
            "motherboard_id", "internet_motherboard_id");
    }

    public function ports(): BelongsToMany
    {
        return $this->belongsToMany(Port::class, "motherboard_ports",
            "motherboard_id", "computer_port_id");
    }

    public function computer_part_interfaces(): BelongsToMany
    {
        return $this->belongsToMany(Computer_interface::class, "motherboard_interfaces",
            "motherboard_id", "interface_id");
    }

    public function sli_crossfire_types(): BelongsToMany
    {
        return $this->belongsToMany(sli_crossfire_type::class, "motherboard_sli_crossfire_types",
            "motherboard_id", "sli_crossfire_type_id");
    }
    public function ratings()
    {
        return $this->morphMany(Rating::class, 'ratingable', "ratingable_type","ratingable_id");
    }

    public function checkExistById($id): bool
    {
        return $this::query()->where('id', $id)->exists();
    }


    public function getItemById($id): FullVersionMotherboardResource
    {
        $motherboard =  $this->addWithToQuery($this::query())
            ->where("id",'=',$id)->first();

        /*$motherboard->m2_slots->each(function ($m2_slot) {
            $this->hidePivotField($m2_slot->m2_form_factors);
        });
        $this->hidePivotField($motherboard->m2_slots);
        $motherboard->frequencies_memory_with_types->each(function ($item) {
            $item->makeHidden(["type_memory_id", "pivot"]);
        });
        $motherboard->onboard_internet_cards->each(function ($item) {
            $item->makeHidden(["manufacturer_id", "pivot"]);
        });
        $this->hidePivotField($motherboard->ports);
        $this->hidePivotField($motherboard->computer_part_interfaces);
        $this->hidePivotField($motherboard->sli_crossfire_types);
        $hidden_columns = ["chipset_id",
            "form_factor_id",
            "manufacturer_id",
            "socket_id",
            "wireless_networking_type_id",
            "memory_type_id",
            "link_id",
            "created_at",
            "updated_at"];
        $motherboard->makeHidden($hidden_columns);*/
        return new FullVersionMotherboardResource($motherboard);
    }

    public static function addWithToQuery($query)
    {
        $query->with([
            "chipset" => function ($query) {
                $query->select(["id", "name"]);
            },
            "form_factor" => function ($query) {
                $query->select(["id", "name"]);
            },
            "manufacturer" => function ($query) {
                $query->select(["id", "name"]);
            },
            "socket" => function ($query) {
                $query->select(["id", "name"]);
            },
            "wireless_networking_type" => function ($query) {
                $query->select(["id", "name"]);
            },
            "memory_type" => function ($query) {
                $query->select(["id", "name"]);
            },
            "m2_slots" => function ($query) {
                $query->with(["m2_form_factors" => function ($query) {
                    $query->select(["m2_form_factors.id",
                        "m2_form_factors.name",
                        "m2_form_factors.key_form_factor"]);
                }])->select(["m2_slots.id", "m2_slots.name"]);
            },
            "frequencies_memory_with_types" => function ($query) {
                $query->with(["type_memory" => function ($query) {
                    $query->select(["type_memories.id", "type_memories.name"]);
                }])->select(["frequencies_memory_with_types.id", "frequencies_memory_with_types.frequency_mhz", "frequencies_memory_with_types.type_memory_id"]);
            },
            "onboard_internet_cards" => function ($query) {
                $query->with(["manufacturer" => function ($query) {
                    $query->select(["manufacturers.id", "manufacturers.name"]);
                }])->select(["internet_motherboards.id",
                    "internet_motherboards.speed_gb_s",
                    "internet_motherboards.model",
                    "internet_motherboards.manufacturer_id",
                    "onboard_internet_motherboards.count"]);
            },
            "ports" => function ($query) {
                $query->select(["ports.id", "ports.name"]);
            },
            "computer_part_interfaces" => function ($query) {
                $query->select(["computer_interfaces.id", "computer_interfaces.name", "motherboard_interfaces.count"]);
            },
            "sli_crossfire_types" => function ($query) {
                $query->select(["sli_crossfire_types.id", "sli_crossfire_types.name", "sli_crossfire_types.count_graphical_card"]);
            }
        ]);
        return $query;
    }
}
