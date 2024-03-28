<?php

namespace App\Http\Filters;
use App\Traits\FilterHelpers;

class MotherboardFilter extends QueryFilter
{
    use FilterHelpers;
    public function countSocket($parameters): void
    {
        $this->filterMinMaxByOneColumn($parameters, "count_sockets", $this->builder);
    }
    public function countMemorySlots($parameters): void
    {
        $this->filterMinMaxByOneColumn($parameters, "count_memory_slots", $this->builder);
    }
    public function memoryMax($parameters): void
    {
        $this->filterMinMaxByOneColumn($parameters, "memory_max_gb", $this->builder);
    }
    public function onboardVideo($parameters): void
    {
        $this->filterByBooleanOrNullValue($parameters, "onboard_video",$this->builder);
    }
    public function supportEcc($parameters): void
    {
        $this->filterByBooleanOrNullValue($parameters, "support_ecc",$this->builder);
    }
    public function raidSupport($parameters): void
    {
        $this->filterByBooleanOrNullValue($parameters, "raid_support",$this->builder);
    }
    public function manufacturer($parameters): void
    {
        $this->filterRelationByName($parameters, "manufacturer", $this->builder);
        /*$this->builder->whereHas("manufacturer", function ($query) use ($parameters) {
            if (is_array($parameters)) {
                $query->whereIn('name', $parameters);
            } elseif (is_string($parameters)) {
                $query->where('name', $parameters);
            }
        });*/
    }
    public function chipset($parameters): void
    {
        $this->filterRelationByName($parameters, "chipset", $this->builder);
    }
    public function formFactor($parameters): void
    {
        $this->filterRelationByName($parameters, "form_factor", $this->builder);
    }
    public function socket($parameters): void
    {
        $this->filterRelationByName($parameters, "socket", $this->builder);
    }
    public function wirelessNetworkingType($parameters): void
    {
        $this->filterRelationByName($parameters, "wireless_networking_type", $this->builder);
    }
    public function memoryType($parameters): void
    {
        $this->filterRelationByName($parameters, "memory_type", $this->builder);
    }
    public function m2Slot($parameters): void
    {
        $this->filterRelationByName($parameters, "m2_slots", $this->builder);
    }
    public function supportedMemory($parameters): void
    {
        $parameters = json_decode($parameters, true);
        if (!is_array($parameters))
        {
            return;
        }
        $first_key = "name";
        $second_key ="frequency";
        $this->builder->where(function ($query) use($parameters, $first_key, $second_key){
            foreach ($parameters as $parameter)
            {
                if (!is_array($parameter))
                {
                    continue;
                }
                if (!array_key_exists($first_key, $parameter) || !array_key_exists($second_key, $parameter)) {
                    logger("Нет необходимых ключей в массиве");
                    return;
                }
                $name_type_memory = $parameter[$first_key];
                $frequency = $parameter[$second_key];
                $query->whereHas("frequencies_memory_with_types.type_memory", function ($query) use($frequency, $name_type_memory){
                   $query->where("frequencies_memory_with_types.frequency_mhz", "=", $frequency)->where("type_memories.name","=", $name_type_memory);
                });
            }
        });
    }
    public function onboardInternetMotherboard($parameters): void
    {
        if(!is_array($parameters)) {
            if (filter_var($parameters, FILTER_VALIDATE_BOOLEAN)) {
                $parameter = boolval($parameters);
            }else {
                return;
            }
            if ($parameter === true)
            {
                $this->builder->whereHas("onboard_internet_cards");
            }
            else{
                $this->builder->whereDoesntHave("onboard_internet_cards");
            }
        }
        else
        {
            $this->builder->where(function ($query) use($parameters){
                foreach ($parameters as $parameter)
                {
                    if (filter_var($parameter, FILTER_VALIDATE_BOOLEAN)) {
                        $converted_parameter = boolval($parameter);
                    } else {
                        continue;
                    }
                    if ($converted_parameter === true)
                    {
                        $query->orWhereHas("onboard_internet_cards");
                    }
                    else{
                        $query->orWhereDoesntHave("onboard_internet_cards");
                    }
                }
            });
        }
    }
    public function port($parameters): void
    {
        $parameters = json_decode($parameters);
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
                    $query->where("name", $name)->whereBetween("motherboard_ports.count", [$min, $max]);
                });
            }
        });
    }
    public function interface($parameters): void
    {
        $parameters = json_decode($parameters);
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
                $query->whereHas("computer_part_interfaces", function ($query) use($name, $min, $max){
                    $query->where("name", $name)->whereBetween("motherboard_interfaces.count", [$min, $max]);
                });
            }
        });
    }
    public function sliCrossfire($parameters): void
    {
        $this->filterRelationByName($parameters, "sli_crossfire_types", $this->builder);
    }
}
