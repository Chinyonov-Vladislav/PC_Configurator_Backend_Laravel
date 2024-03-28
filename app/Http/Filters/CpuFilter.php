<?php

namespace App\Http\Filters;

use App\Traits\FilterHelpers;

class CpuFilter extends QueryFilter
{
    use FilterHelpers;

    public function performanceCoreClock($parameters): void
    {
        $this->filterMinMaxByOneColumn($parameters,"performance_core_clock_ghz", $this->builder);
    }
    public function coreCount($parameters): void
    {
        $this->filterMinMaxByOneColumn($parameters,"core_count", $this->builder);
    }
    public function performanceBoostClock($parameters): void
    {
        $this->filterMinMaxByOneColumn($parameters,"performance_boost_clock_ghz", $this->builder);
    }
    public function tdp($parameters): void
    {
        $this->filterMinMaxByOneColumn($parameters,"tdp_w", $this->builder);
    }
    public function includesCooler($parameters): void
    {
        $this->filterByBooleanOrNullValue($parameters, "includes_cooler", $this->builder);
    }
    public function eccSupport($parameters): void
    {
        $this->filterByBooleanOrNullValue($parameters, "ecc_support", $this->builder);
    }
    public function maximumSupportedMemory($parameters): void
    {
        $this->filterMinMaxByOneColumn($parameters,"maximum_supported_memory_gb", $this->builder);
    }
    public function l1CachePerformanceData($parameters): void
    {
        $this->filterMinMaxByOneColumn($parameters,"l1_cache_performance_data_kbs", $this->builder);
    }
    public function l1CachePerformanceInstruction($parameters): void
    {
        $this->filterMinMaxByOneColumn($parameters,"l1_cache_performance_instruction_kbs", $this->builder);
    }
    public function l1CacheEfficiencyInstruction($parameters): void
    {
        $this->filterMinMaxByOneColumn($parameters,"l1_cache_efficiency_instruction_kbs", $this->builder);
    }
    public function l1CacheEfficiencyData($parameters): void
    {
        $this->filterMinMaxByOneColumn($parameters,"l1_cache_efficiency_data_kbs", $this->builder);
    }
    public function l2CachePerformance($parameters): void
    {
        $this->filterMinMaxByOneColumn($parameters,"l2_cache_performance_mbs", $this->builder);
    }
    public function l2CacheEfficiency($parameters): void
    {
        $this->filterMinMaxByOneColumn($parameters,"l2_cache_efficiency_mbs", $this->builder);
    }
    public function l3Cache($parameters): void
    {
        $this->filterMinMaxByOneColumn($parameters,"l3_cache_mbs", $this->builder);
    }
    public function lithography($parameters)
    {
        $this->filterMinMaxByOneColumn($parameters, "lithography_nm", $this->builder);
    }
    public function multithreading($parameters): void
    {
        $this->filterByBooleanOrNullValue($parameters, "multithreading",$this->builder);
    }
    public function SMT($parameters): void
    {
        $this->filterByBooleanOrNullValue($parameters, "SMT",$this->builder);
    }
    public function includesCpuCooler($parameters): void
    {
        $this->filterByBooleanOrNullValue($parameters, "includes_cpu_cooler",$this->builder);
    }
    public function manufacturer($parameters): void
    {
        $this->filterRelationByName($parameters, "manufacturer", $this->builder);

        /*if (!is_array($parameters) && !is_string($parameters)) {
            return;
        }
        $this->builder->whereHas("manufacturer", function ($query) use ($parameters) {
            if (is_array($parameters)) {
                $query->whereIn('name', $parameters);
            } elseif (is_string($parameters)) {
                $query->where('name', $parameters);
            }
        });*/
    }
    public function coreFamily($parameters): void
    {
        $this->filterRelationByName($parameters, "core_family", $this->builder);
    }
    public function integratedGraphics($parameters): void
    {
        $this->filterRelationByName($parameters, "integrated_graphic", $this->builder);
    }
    public function microarchitecture($parameters): void
    {
        $this->filterRelationByName($parameters, "microarchitecture", $this->builder);
    }
    public function packaging($parameters): void
    {
        $this->filterRelationByName($parameters, "packaging", $this->builder);
    }
    public function series($parameters): void
    {
        $this->filterRelationByName($parameters, "series", $this->builder);
    }
    public function socket($parameters): void
    {
        $this->filterRelationByName($parameters, "socket", $this->builder);
    }
}
