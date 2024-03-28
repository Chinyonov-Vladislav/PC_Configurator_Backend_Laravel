<?php

namespace App\Http\Resources\ShortVersionComputerPart;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShortVersionGraphicalCardResource extends JsonResource
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
            "TDP_w"=>$this->TDP_w,
            "count_memory_gb"=>$this->count_memory_gb,
            "memory_type"=>$this->memory_type?->name
        ];
    }
}
