<?php

namespace App\Http\Resources\FullVersionComputerPart;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FullVersionComputerCaseResource extends JsonResource
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
            "model" => $this->model,
            "volume" => $this->volume,
            "dimension_length" => $this->dimension_length,
            "dimension_width" => $this->dimension_width,
            "dimension_height" => $this->dimension_height,
            "color" => $this->color,
            "manufacturer" => $this->manufacturer,
            "side_panel" => $this->side_panel,
            "form_factor" => $this->form_factor,
            "compatibility_with_videocard_types" => $this->compatibility_with_videocard_types->map(function ($item) {
                return [
                    "id_compatibility" => $item->compatibility_with_videocard_type_id,
                    "name"=> $item->name,
                    "maximum_length_videocard_in_mm" => $item->maximum_length_videocard_in_mm
                ];
            }),
            "compatibility_with_videocard_without_type" => $this->compatibility_with_videocard_without_type === null ? null :
                [
                    "id_compatibility" => $this->compatibility_with_videocard_without_type->compatibility_with_videocard_type_id,
                    "maximum_length_videocard_in_mm" => $this->compatibility_with_videocard_without_type->maximum_length_videocard_in_mm,
                ],
            "ports" => $this->ports->map(function ($port) {
                return [
                    'id' => $port->id,
                    'name' => $port->name,
                ];
            }),
            "drive_bays" => $this->drive_bays->map(function ($drive_bay) {
                return [
                    'id' => $drive_bay->id,
                    'name' => $drive_bay->name,
                    'count' => $drive_bay->count,
                ];
            })
        ];
    }
}
