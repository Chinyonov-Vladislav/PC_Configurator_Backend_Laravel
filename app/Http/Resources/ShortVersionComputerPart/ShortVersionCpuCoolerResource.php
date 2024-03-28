<?php

namespace App\Http\Resources\ShortVersionComputerPart;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShortVersionCpuCoolerResource extends JsonResource
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
            "fanRpm"=>$this->fan_rpm !== null ? str($this->fan_rpm) :
                ($this->fan_rpm_min !== null && $this->fan_rpm_max !== null ? str($this->fan_rpm_min)." - ".str($this->fan_rpm_max) : null),
            "noiseLevel"=> $this->noise_level !== null ? str($this->noise_level) :
                ($this->noise_level_min !== null && $this->noise_level_max !== null ? str($this->noise_level_min)." - ".str($this->noise_level_max) : null),
            "height_mm"=>$this->height_mm
        ];
    }
}
