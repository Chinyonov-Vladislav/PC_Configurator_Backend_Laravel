<?php

namespace App\Http\Resources\ShortVersionComputerPart;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShortVersionStorageDeviceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'image' => $this->image,
            "model"=>$this->model,
            "nameManufacturer"=>$this->manufacturer?->name,
            "capacity"=>$this->capacity_gb,
            "type"=>$this->type_internal_storage_device?->name,
            "rpm"=>$this->rpm,
            "form_factor"=>$this->form_factor?->name,
            "interface"=>$this->interface?->name
        ];
    }
}
