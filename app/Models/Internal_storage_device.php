<?php

namespace App\Models;

use App\Http\Filters\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Internal_storage_device extends Model
{
    use Filterable;
    use HasFactory;
    protected $guarded = [];
    public function form_factor(): BelongsTo
    {
        return $this->belongsTo(Computer_part_form_factor::class,"form_factor_id");
    }
    public function interface(): BelongsTo
    {
        return $this->belongsTo(Computer_part_interface::class, "interface_id");
    }
    public function ssd_controller(): BelongsTo
    {
        return $this->belongsTo(Computer_part_controller::class,"ssd_controller_id");
    }
    public function type_internal_storage_device(): BelongsTo
    {
        return $this->belongsTo(Type_internal_storage_device::class, "type_internal_storage_device_id");
    }
    public function ssd_nand_flash_type(): BelongsTo
    {
        return $this->belongsTo(ssd_nand_flash_type::class, "ssd_nand_flash_type_id");
    }
    public function manufacturer(): BelongsTo
    {
        return $this->belongsTo(Manufacturer::class,"manufacturer_id");
    }
    public function link(): BelongsTo
    {
        return $this->belongsTo(Computer_parts_link::class,"link_id");
    }
}
