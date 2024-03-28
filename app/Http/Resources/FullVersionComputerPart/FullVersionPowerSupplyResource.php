<?php

namespace App\Http\Resources\FullVersionComputerPart;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FullVersionPowerSupplyResource extends JsonResource
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
            "wattage_w" => $this->wattage_w,
            "length_mm" => $this->length_mm,
            "efficiency_percent" => $this->efficiency_percent,
            "fanless" => $this->fanless,
            "model" => $this->model,
            "color" => $this->color,
            "manufacturer" => $this->manufacturer,
            "efficiency_rating" => $this->efficiency_rating,
            "modular_type" => $this->modular_type,
            "form_factor" => $this->form_factor,
            "outputs" => $this->outputs->map(function ($output) {
                return [
                    "id" => $output->id,
                    "name" => $output->name
                ];
            }),
            "connectors" => $this->connectors->map(function ($connector) {
                return [
                    "id" => $connector->id,
                    "name" => $connector->name,
                    "count" => $connector->count
                ];
            })
        ];
    }
}
