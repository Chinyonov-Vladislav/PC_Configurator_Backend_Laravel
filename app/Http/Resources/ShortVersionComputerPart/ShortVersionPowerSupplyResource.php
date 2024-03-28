<?php

namespace App\Http\Resources\ShortVersionComputerPart;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShortVersionPowerSupplyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            //$this->resource
            'id' => $this->id,
            'image' => $this->image,
            "model"=>$this->model,
            "nameManufacturer"=>$this->manufacturer?->name,
            "wattage_w"=>$this->wattage_w,
            "formFactor"=>$this->form_factor?->name,
            "modular_type"=>$this->modular_type?->name,
            "efficiency_rating"=>$this->efficiency_rating?->name
        ];
    }
}
