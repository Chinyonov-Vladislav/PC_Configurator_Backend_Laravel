<?php

namespace App\Models;

use App\Http\Filters\Filterable;
use App\Http\Resources\FullVersionComputerPart\FullVersionStorageDeviceResource;
use App\Interfaces\QueryableAdditionalWithInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Internal_storage_device extends Model implements QueryableAdditionalWithInterface
{
    use Filterable;
    use HasFactory;
    protected $guarded = [];
    protected $casts = [
        'price_for_gb' => 'float',
        "nvme"=>"boolean",
        "power_loss_protection"=>"boolean"
    ];
    public function form_factor(): BelongsTo
    {
        return $this->belongsTo(Form_factor::class,"form_factor_id");
    }
    public function interface(): BelongsTo
    {
        return $this->belongsTo(Computer_interface::class, "interface_id");
    }
    public function ssd_controller(): BelongsTo
    {
        return $this->belongsTo(Controller::class,"ssd_controller_id");
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
    public function ratings()
    {
        return $this->morphMany(Rating::class, 'ratingable', "ratingable_type","ratingable_id");
    }
    public function checkExistById($id): bool
    {
        return $this::query()->where('id', $id)->exists();
    }
    public function getItemById($id): FullVersionStorageDeviceResource
    {
        /*$hidden_columns = ["form_factor_id",
            "interface_id",
            "ssd_controller_id",
            "type_internal_storage_device_id",
            "ssd_nand_flash_type_id",
            "manufacturer_id",
            "link_id",
            "created_at",
            "updated_at"];*/
        $item = $this->addWithToQuery($this::query())
            ->where("id",'=',$id)->first();
        return new FullVersionStorageDeviceResource($item);
    }

    public static function addWithToQuery($query)
    {
        $query->with([
            "form_factor"=>function ($query) {
                $query->select(["id","name"]);
            },
            "interface"=>function ($query) {
                $query->select(["id","name"]);
            },
            "ssd_controller"=>function ($query) {
                $query->select(["id","name"]);
            },
            "type_internal_storage_device"=>function ($query) {
                $query->select(["id","name"]);
            },
            "ssd_nand_flash_type"=>function ($query) {
                $query->select(["id","name"]);
            },
            "manufacturer"=>function ($query) {
                $query->select(["id","name"]);
            }]);
        return $query;
    }
}
