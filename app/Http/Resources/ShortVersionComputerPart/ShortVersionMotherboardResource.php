<?php

namespace App\Http\Resources\ShortVersionComputerPart;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShortVersionMotherboardResource extends JsonResource
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
            "socket"=> $this->socket !== null ? ($this->count_sockets !== null ? str($this->count_sockets)." X ".str($this->socket->name) :null ) : null,
            "formFactor"=>$this->form_factor?->name,
            "chipset"=>$this->chipset?->name,


        ];
    }
}
