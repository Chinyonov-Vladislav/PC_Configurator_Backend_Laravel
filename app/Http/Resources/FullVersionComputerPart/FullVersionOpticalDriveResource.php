<?php

namespace App\Http\Resources\FullVersionComputerPart;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FullVersionOpticalDriveResource extends JsonResource
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
            "buffer_cache_mb"=>$this->buffer_cache_mb,
            "bd_minus_rom_speed"=>$this->bd_minus_rom_speed,
            "dvd_minus_rom_speed"=>$this->dvd_minus_rom_speed,
            "cd_minus_rom_speed"=>$this->cd_minus_rom_speed,
            "bd_minus_r_Speed"=>$this->bd_minus_r_Speed,
            "bd_minus_r_dual_layer_speed"=>$this->bd_minus_r_dual_layer_speed,
            "bd_minus_re_speed"=>$this->bd_minus_re_speed,
            "bd_minus_re_dual_layer_speed"=>$this->bd_minus_re_dual_layer_speed,
            "dvd_plus_r_speed"=>$this->dvd_plus_r_speed,
            "dvd_plus_rw_speed"=>$this->dvd_plus_rw_speed,
            "dvd_plus_r_dual_layer_speed"=>$this->dvd_plus_r_dual_layer_speed,
            "dvd_minus_rw_speed"=>$this->dvd_minus_rw_speed,
            "dvd_minus_r_dual_layer_speed"=>$this->dvd_minus_r_dual_layer_speed,
            "dvd_minus_ram_speed"=>$this->dvd_minus_ram_speed,
            "cd_minus_r_speed"=>$this->cd_minus_r_speed,
            "cd_minus_rw_speed"=>$this->cd_minus_rw_speed,
            "dvd_minus_r_speed"=>$this->dvd_minus_r_speed,
            "color"=>$this->color,
            "manufacturer"=>$this->manufacturer,
            "form_factor"=>$this->form_factor,
            "interface"=> $this->interface
        ];
    }
}
