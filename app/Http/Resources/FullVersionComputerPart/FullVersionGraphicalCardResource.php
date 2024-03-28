<?php

namespace App\Http\Resources\FullVersionComputerPart;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FullVersionGraphicalCardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "image" => $this->image,
            "count_memory_gb" => $this->count_memory_gb,
            "clock_core_mhz" => $this->clock_core_mhz,
            "boost_clock_mhz" => $this->boost_clock_mhz,
            "length_mm" => $this->length_mm,
            "TDP_w" => $this->TDP_w,
            "total_slot_width" => $this->total_slot_width,
            "case_expansion_slot_width" => $this->case_expansion_slot_width,
            "effective_memory_clock_mhz" => $this->effective_memory_clock_mhz,
            "model" => $this->model,
            "manufacturer" => $this->manufacturer,
            "chipset" => $this->chipset,
            "color" => $this->color,
            "cooling_type" => $this->cooling_type,
            "memory_type" => $this->memory_type,
            "frame_sync_type" => $this->frame_sync_type,
            "interface" => $this->interface,
            "sli_crossfire_types" => $this->sli_crossfire_types->map(function ($sli_crossfire_type) {
                return [
                    "id" => $sli_crossfire_type->id,
                    "name" => $sli_crossfire_type->name,
                    "count_graphical_card"=>$sli_crossfire_type->count_graphical_card
                ];
            }),
            "ports" => $this->ports->map(function ($port) {
                return [
                    "id" =>$port->id,
                    "name" =>$port->name,
                    "count" =>$port->count
                ];
            }),
        ];
    }
}
