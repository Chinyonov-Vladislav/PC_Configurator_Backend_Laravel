<?php

namespace App\Http\Resources\FullVersionComputerPart;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FullVersionStorageDeviceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=>$this->id,
            "image"=>$this->image,
            "cache_mb"=>$this->cache_mb,
            "capacity_gb"=>$this->capacity_gb,
            "price_for_gb"=>$this->price_for_gb,
            "nvme"=>$this->nvme,
            "full_disk_write_throughput_mb_s"=>$this->full_disk_write_throughput_mb_s,
            "full_disk_write_throughput_last_10_seconds_mb_s"=>$this->full_disk_write_throughput_last_10_seconds_mb_s,
            "random_read_throughput_disk_50_full"=>$this->random_read_throughput_disk_50_full,
            "random_write_throughput_disk_50_full"=>$this->random_write_throughput_disk_50_full,
            "sequential_read_throughput_disk_50_full"=>$this->sequential_read_throughput_disk_50_full,
            "sequential_write_throughput_disk_50_full"=>$this->sequential_write_throughput_disk_50_full,
            "model"=>$this->model,
            "power_loss_protection"=>$this->power_loss_protection,
            "hybrid_ssd_cache_mb"=>$this->hybrid_ssd_cache_mb,
            "rpm"=>$this->rpm,
            "form_factor"=>$this->form_factor,
            "interface"=>$this->interface,
            "ssd_controller"=>$this->ssd_controller,
            "type_internal_storage_device"=>$this->type_internal_storage_device,
            "ssd_nand_flash_type"=>$this->ssd_nand_flash_type,
            "manufacturer"=> $this->manufacturer
        ];
    }
}
