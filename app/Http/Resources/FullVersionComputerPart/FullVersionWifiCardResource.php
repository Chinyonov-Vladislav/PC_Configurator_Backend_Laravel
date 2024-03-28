<?php

namespace App\Http\Resources\FullVersionComputerPart;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FullVersionWifiCardResource extends JsonResource
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
            "interface"=>$this->interface,
            "manufacturer"=>$this->manufacturer,
            "protocol"=>$this->protocol,
            "operating_range"=>$this->operating_range,
            "color"=>$this->color,
            "antenna"=>$this->antenna,
            "securities"=> $this->securities->map(function ($security){
                return [
                    "id"=>$security->id,
                    "name"=>$security->name,
                ];
            })
        ];
    }
}
