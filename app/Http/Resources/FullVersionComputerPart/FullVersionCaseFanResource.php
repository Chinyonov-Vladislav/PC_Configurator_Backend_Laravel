<?php

namespace App\Http\Resources\FullVersionComputerPart;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FullVersionCaseFanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" =>$this->id,
            "image" =>$this->image,
            "model" =>$this->model,
            "airflow_min" =>$this->airflow_min,
            "airflow" =>$this->airflow,
            "airflow_max" =>$this->airflow_max,
            "noise_level_min" =>$this->noise_level_min,
            "noise_level" =>$this->noise_level,
            "noise_level_max" =>$this->noise_level_max,
            "rpm_min" =>$this->rpm_min,
            "rpm" =>$this->rpm,
            "rpm_max" =>$this->rpm_max,
            "pmw" =>$this->pmw,
            "size_mm" =>$this->size_mm,
            "static_pressure" =>$this->static_pressure,
            "quantity_in_pack" =>$this->quantity_in_pack,
            "manufacturer" =>$this->manufacturer,
            "color" =>$this->color,
            "connector" =>$this->connector,
            "controller" =>$this->controller,
            "led" =>$this->led,
            "bearing_type" =>$this->bearing_type
        ];
    }
}
