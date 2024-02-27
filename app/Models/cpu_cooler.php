<?php

namespace App\Models;

use App\Http\Filters\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class cpu_cooler extends Model
{
    use HasFactory;
    use Filterable;
    protected $guarded = [];
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
        return $this->belongsTo(Computer_part_bearing_type::class, "bearing_type_id");
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
}
