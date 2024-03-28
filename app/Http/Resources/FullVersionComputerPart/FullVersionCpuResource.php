<?php

namespace App\Http\Resources\FullVersionComputerPart;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FullVersionCpuResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        //return [$this->resource];
        return [
            "id"=>$this->id,
            "image"=>$this->image,
            "performance_core_clock_ghz"=>$this->performance_core_clock_ghz,
            "core_count"=>$this->core_count,
            "performance_boost_clock_ghz"=>$this->performance_boost_clock_ghz,
            "tdp_w"=>$this->tdp_w,
            "includes_cooler"=>$this->includes_cooler,
            "ecc_support"=>$this->ecc_support,
            "maximum_supported_memory_gb"=>$this->maximum_supported_memory_gb,
            "l1_cache_performance_data_kbs"=>$this->l1_cache_performance_data_kbs,
            "l1_cache_performance_instruction_kbs"=>$this->l1_cache_performance_instruction_kbs,
            "l1_cache_efficiency_instruction_kbs"=>$this->l1_cache_efficiency_instruction_kbs,
            "l1_cache_efficiency_data_kbs"=>$this->l1_cache_efficiency_data_kbs,
            "l2_cache_performance_mbs"=>$this->l2_cache_performance_mbs,
            "l2_cache_efficiency_mbs"=>$this->l2_cache_efficiency_mbs,
            "l3_cache_mbs"=>$this->l3_cache_mbs,
            "lithography_nm"=>$this->lithography_nm,
            "multithreading"=>$this->multithreading,
            "SMT"=>$this->SMT,
            "includes_cpu_cooler"=>$this->includes_cpu_cooler,
            "model"=>$this->model,
            "manufacturer"=>$this->manufacturer,
            "core_family"=>$this->core_family,
            "integrated_graphic"=>$this->integrated_graphic,
            "microarchitecture"=>$this->microarchitecture,
            "packaging"=>$this->packaging,
            "series"=>$this->series,
            "socket"=> $this->socket
        ];
    }
}
