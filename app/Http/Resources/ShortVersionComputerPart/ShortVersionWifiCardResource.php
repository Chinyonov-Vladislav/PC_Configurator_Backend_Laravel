<?php

namespace App\Http\Resources\ShortVersionComputerPart;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShortVersionWifiCardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $securities = [];
        if($this->securities!=null)
        {
            foreach($this->securities as $item)
            {
                $securities[] = $item->name;
            }
        }
        $result_str_securities = null;
        if(count($securities)>0)
        {
            $result_str_securities = implode(', ', $securities);
        }
        return [
            'id' => $this->id,
            'image' => $this->image,
            "model"=>$this->model,
            "nameManufacturer"=>$this->manufacturer?->name,
            "interface"=>$this->interface?->name,
            "protocol"=>$this->protocol?->name,
            "antenna"=>$this->antenna?->name,
            "securities"=>$result_str_securities
        ];
    }
}
