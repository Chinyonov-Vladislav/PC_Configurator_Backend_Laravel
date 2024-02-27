<?php

namespace App\Models;

use App\Http\Filters\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Power_supply extends Model
{
    use HasFactory;
    use Filterable;
    protected $guarded = [];
    public function color_id(): BelongsTo
    {
        return $this->belongsTo(Color::class, "color_id");
    }
    public function manufacturer_id(): BelongsTo
    {
        return $this->belongsTo(Manufacturer::class, "manufacturer_id");
    }
    public function efficiency_rating_id(): BelongsTo
    {
        return $this->belongsTo(Efficiency_rating::class, "efficiency_rating_id");
    }
    public function modular_type_id(): BelongsTo
    {
        return $this->belongsTo(Modular_power_supply_type::class, "modular_type_id");
    }
    public function form_factor_id(): BelongsTo
    {
        return $this->belongsTo(Computer_part_form_factor::class, "form_factor_id");
    }
    public function link_id(): BelongsTo
    {
        return $this->belongsTo(Computer_parts_link::class, "link_id");
    }
    public function outputs(): BelongsToMany
    {
        return $this->belongsToMany(Output_power_supply_type::class,"power_supply_outputs",
            "output_type_id","power_supply_id");
    }
    public function computer_part_connectors(): BelongsToMany
    {
        return $this->belongsToMany(Computer_part_connector::class, "power_supply_connectors",
            "power_supply_id","connector_id");
    }
}
