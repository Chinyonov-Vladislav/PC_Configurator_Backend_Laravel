<?php

namespace App\Http\Resources\ShortVersionComputerPart;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShortVersionRamResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $speed = null;
        if($this->speed !== null)
        {
            if($this->speed->type_memory!==null)
            {
                $speed = str($this->speed->type_memory->name)." - ".str($this->speed->frequency_mhz);
            }
        }
        return [
            //$this->resource,
            'id' => $this->id,
            'image' => $this->image,
            "model"=>$this->model,
            "nameManufacturer"=>$this->manufacturer?->name,
            "total_capacity_memory"=>$this->total_capacity_memory !== null ? round($this->total_capacity_memory / 1024,2) : null,
            "module"=> $this->module !== null ? str($this->module->count)." X ".round($this->module->capacity_one_ram_mb / 1024,2)." Gb" : null,
            "form_factor"=> $this->form_factor?->name,
            "speed"=>$speed
        ];
    }
}
