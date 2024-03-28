<?php

namespace App\Http\Resources\ShortVersionComputerPart;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShortVersionComputerCaseResource extends JsonResource
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
            "dimension"=> $this->dimension_length !== null && $this->dimension_width !== null && $this->dimension_height !== null ?
                str($this->dimension_length)." X ".str($this->dimension_width)." X ".str($this->dimension_height) : null,
            "nameManufacturer"=>$this->manufacturer?->name,
            "nameFormFactor"=>$this->form_factor?->name,
            "nameSidePanel"=>$this->side_panel?->name
        ];
    }
}
