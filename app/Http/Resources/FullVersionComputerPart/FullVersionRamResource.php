<?php

namespace App\Http\Resources\FullVersionComputerPart;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FullVersionRamResource extends JsonResource
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
            "model"=>$this->model,
            "total_capacity_memory"=>$this->total_capacity_memory,
            "cas_latency"=>$this->cas_latency,
            "first_word_latency"=>$this->first_word_latency,
            "heat_spreader"=>$this->heat_spreader,
            "voltage"=>$this->voltage,
            "price_gb"=>$this->price_gb,
            "color"=>$this->color,
            "manufacturer"=>$this->manufacturer,
            "form_factor"=>$this->form_factor,
            "module"=>$this->module,
            "timing"=>$this->timing,
            "speed"=>$this->speed === null ? null : [
                "id"=> $this->speed->id,
                "frequency_mhz"=> $this->speed->frequency_mhz,
                "type_memory"=> $this->speed->type_memory
            ],
            "ecc_registered_type"=>$this->ecc_registered_type,
        ];
    }
}
