<?php

namespace App\Http\Resources\ShortVersionComputerPart;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShortVersionWiredNetworkCardResource extends JsonResource
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
            "nameColor"=> $this->color?->name,
            "nameInterface"=>$this->interface?->name
        ];
    }
}
