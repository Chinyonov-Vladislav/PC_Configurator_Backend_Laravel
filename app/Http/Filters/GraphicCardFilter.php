<?php

namespace App\Http\Filters;

use App\Traits\FilterHelpers;

class GraphicCardFilter extends QueryFilter
{
    use FilterHelpers;

    public function countMemory($parameters): void
    {
        $this->filterMinMaxByOneColumn($parameters, "count_memory_gb",$this->builder);
    }
    public function clockCore($parameters): void
    {
        $this->filterMinMaxByOneColumn($parameters, "clock_core_mhz",$this->builder);
    }
    public function boostClock($parameters): void
    {
        $this->filterMinMaxByOneColumn($parameters, "boost_clock_mhz",$this->builder);
    }
    public function length($parameters): void
    {
        $this->filterMinMaxByOneColumn($parameters, "length_mm",$this->builder);
    }
    public function tdp($parameters): void
    {
        $this->filterMinMaxByOneColumn($parameters, "TDP_w",$this->builder);
    }
    public function totalSlotWidth($parameters): void
    {
        $this->filterMinMaxByOneColumn($parameters, "total_slot_width",$this->builder);
    }
    public function caseExpansionSlotWidth($parameters): void
    {
        $this->filterMinMaxByOneColumn($parameters, "case_expansion_slot_width",$this->builder);
    }
    public function effectiveMemoryClock($parameters): void
    {
        $this->filterMinMaxByOneColumn($parameters, "effective_memory_clock_mhz",$this->builder);
    }
    public function manufacturer($parameters): void
    {
        $this->filterRelationByName($parameters, "manufacturer", $this->builder);
    }
    public function chipset($parameters): void
    {
        $this->filterRelationByName($parameters, "chipset", $this->builder);
    }
    public function color($parameters): void
    {
        $this->filterRelationByName($parameters, "color", $this->builder);
    }
    public function coolingType($parameters): void
    {
        $this->filterRelationByName($parameters, "cooling_type", $this->builder);
    }
    public function externalPowerType($parameters): void
    {
        $this->filterRelationByName($parameters, "external_power_type", $this->builder);
    }
    public function memoryType($parameters): void
    {
        $this->filterRelationByName($parameters, "memory_type", $this->builder);
    }
    public function frameSyncType($parameters): void
    {
        $this->filterRelationByName($parameters, "frame_sync_type", $this->builder);
    }
    public function interface($parameters): void
    {
        $this->filterRelationByName($parameters, "interface", $this->builder);
    }
    public function sliCrossfireType($parameters): void
    {
        $this->filterRelationByName($parameters, "sli_crossfire_types", $this->builder);
    }
    public function port($parameters): void // выбираются видеокарты, которые имеют одновременно несколько портов в количестве между min и max
    {
        $parameters = json_decode($parameters, true);
        if(!is_array($parameters))
        {
            return;
        }
        $first_name_key = "name";
        $second_min_key = "min";
        $third_max_key = "max";
        $this->builder->where(function ($query) use($parameters, $first_name_key, $second_min_key, $third_max_key){
            foreach ($parameters as $parameter)
            {
                $parameter = (array) $parameter;
                if (!array_key_exists($first_name_key, $parameter) || !array_key_exists($second_min_key, $parameter) || !array_key_exists($third_max_key, $parameter)) {
                    logger("Нет необходимых ключей в массиве");
                    return;
                }
                $name = $parameter[$first_name_key];
                $min = $parameter[$second_min_key];
                $max = $parameter[$third_max_key];
                $query->whereHas("ports", function ($query) use($name, $min, $max){
                   $query->where("name", $name)->whereBetween("graphical_card_ports.count", [$min, $max]);
                });
            }
        });

    }
}
