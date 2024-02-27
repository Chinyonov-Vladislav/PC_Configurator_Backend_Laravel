<?php

namespace App\Models;

use App\Http\Filters\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class cpu extends Model
{
    use Filterable;
    use HasFactory;
    protected $guarded = [];
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
}
