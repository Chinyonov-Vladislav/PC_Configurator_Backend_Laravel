<?php

namespace App\Http\Resources\ShortVersionComputerPart;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShortVersionSoundCardResource extends JsonResource
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
            "chipset"=>$this->chipset?->name,
            "channel"=>$this->channel?->name,
            "interface"=>$this->interface?->name,
            "bitDepth"=>$this->sound_card_bit_depth?->name
        ];
    }
}
