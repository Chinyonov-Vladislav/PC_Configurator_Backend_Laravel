<?php

namespace App\Http\Resources\ShortVersionComputerPart;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShortVersionCaseFanResource extends JsonResource
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
            "airflow"=>$this->airflow !== null ? str($this->airflow) :
                ($this->airflow_min !== null && $this->airflow_max !== null ? str($this->airflow_min)." - ".str($this->airflow_max) : null),
            "noiseLevel"=> $this->noise_level !== null ? str($this->noise_level) :
                ($this->noise_level_min !== null && $this->noise_level_max !== null ? str($this->noise_level_min)." - ".str($this->noise_level_max) : null),
            "rpm"=>$this->rpm !== null ? str($this->rpm) :
                ($this->rpm_min !== null && $this->rpm_max !== null ? str($this->rpm_min)." - ".str($this->rpm_max) : null)
        ];
    }
}
