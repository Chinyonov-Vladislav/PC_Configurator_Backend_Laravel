<?php

namespace App\Http\Resources\FullVersionComputerPart;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FullVersionCpuCoolerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" =>$this->id,
            "image" =>$this->image,
            "fanless" =>$this->fanless,
            "fan_rpm_min" =>$this->fan_rpm_min,
            "fan_rpm_max" =>$this->fan_rpm_max,
            "fan_rpm" =>$this->fan_rpm,
            "height_mm" =>$this->height_mm,
            "noise_level_min" =>$this->noise_level_min,
            "noise_level_max" =>$this->noise_level_max,
            "noise_level" =>$this->noise_level,
            "radiator_size" =>$this->radiator_size,
            "water_cooled" =>$this->water_cooled,
            "model" =>$this->model,
            "color" =>$this->color,
            "manufacturer" =>$this->manufacturer,
            "bearing_type" =>$this->bearing_type,
            "sockets" =>$this->sockets->map(function ($socket) {
                return [
                    'id' => $socket->id,
                    'name' => $socket->name,
                ];
            })
        ];
    }
}
