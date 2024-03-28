<?php

namespace App\Http\Resources\FullVersionComputerPart;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FullVersionMotherboardResource extends JsonResource
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
            "count_sockets"=>$this->count_sockets,
            "count_memory_slots"=>$this->count_memory_slots,
            "memory_max_gb"=>$this->memory_max_gb,
            "onboard_video"=>$this->onboard_video,
            "support_ecc"=>$this->support_ecc,
            "raid_support"=>$this->raid_support,
            "chipset"=>$this->chipset,
            "form_factor"=>$this->form_factor,
            "manufacturer"=>$this->manufacturer,
            "socket"=>$this->socket,
            "wireless_networking_type"=>$this->wireless_networking_type,
            "memory_type"=>$this->memory_type,
            "m2_slots"=>$this->m2_slots->map(function ($m2_slot){
                return [
                    "id"=>$m2_slot->id,
                    "name"=>$m2_slot->name,
                    "m2_form_factors"=>$m2_slot->m2_form_factors->map(function ($form_factor){
                        return [
                            "id"=>$form_factor->id,
                            "name"=>$form_factor->name,
                            "key_form_factor"=>$form_factor->key_form_factor,
                        ];
                    })
                ];
            }),
            "frequencies_memory_with_types"=>$this->frequencies_memory_with_types->map(function ($item){
                return [
                    "id"=>$item->id,
                    "frequency_mhz"=>$item->frequency_mhz,
                    "type_memory"=>$item->type_memory
                ];
            }),
            "onboard_internet_cards"=>$this->onboard_internet_cards->map(function ($item){
                return [
                    "id"=>$item->id,
                    "speed_gb_s"=>$item->speed_gb_s,
                    "model"=>$item->model,
                    "count"=>$item->count,
                    "manufacturer"=>$item->manufacturer
                ];
            }),
            "ports"=>$this->ports->map(function ($port){
                return [
                    "id"=>$port->id,
                    "name"=>$port->name
                ];
            }),
            "computer_part_interfaces"=>$this->computer_part_interfaces->map(function ($item) {
                return [
                    "id" =>$item->id,
                    "name"=>$item->name,
                    "count"=> $item->count
                ];
            }),
            "sli_crossfire_types"=>$this->sli_crossfire_types->map(function ($item){
                return [
                    "id"=> $item->id,
                    "name"=>$item->name,
                    "count_graphical_card"=>$item->count_graphical_card
                ];
            })
        ];
    }
}
