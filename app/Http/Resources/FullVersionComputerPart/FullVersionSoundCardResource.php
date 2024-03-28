<?php

namespace App\Http\Resources\FullVersionComputerPart;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FullVersionSoundCardResource extends JsonResource
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
            "value_sample_rate_hz"=>$this->value_sample_rate_hz,
            "signal_to_noise_ratio"=>$this->signal_to_noise_ratio,
            "color"=>$this->color,
            "chipset"=>$this->chipset,
            "channel"=>$this->channel,
            "interface"=>$this->interface,
            "sound_card_bit_depth"=>$this->sound_card_bit_depth,
            "manufacturer"=> $this->manufacturer
        ];
    }
}
