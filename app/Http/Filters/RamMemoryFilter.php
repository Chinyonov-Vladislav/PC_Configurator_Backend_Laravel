<?php

namespace App\Http\Filters;

use App\Traits\FilterHelpers;

class RamMemoryFilter extends QueryFilter
{
    use FilterHelpers;
    public function totalCapacityMemory($parameters): void
    {
        $this->filterMinMaxByOneColumn($parameters, "total_capacity_memory", $this->builder);
    }
    public function casLatency($parameters): void
    {
        $this->filterMinMaxByOneColumn($parameters, "cas_latency", $this->builder);
    }
    public function firstWordLatency($parameters): void
    {
        $this->filterMinMaxByOneColumn($parameters, "first_word_latency", $this->builder);
    }
    public function heatSpreader($parameters): void
    {
        $this->filterByBooleanOrNullValue($parameters, "heat_spreader", $this->builder);
    }
    public function voltage($parameters): void
    {
        $this->filterMinMaxByOneColumn($parameters, "voltage", $this->builder);
    }
    public function priceGb($parameters): void
    {
        $this->filterMinMaxByOneColumn($parameters, "price_gb", $this->builder);
    }
    public function manufacturer($parameters): void
    {
        $this->filterRelationByName($parameters, "manufacturer", $this->builder);
    }
    public function color($parameters): void
    {
        $this->filterRelationByName($parameters, "color", $this->builder);
    }
    public function formFactor($parameters): void
    {
        $this->filterRelationByName($parameters, "form_factor", $this->builder);
    }
    public function module($parameters): void
    {
        $parameters = json_decode($parameters);
        if (!is_array($parameters)) {
            return;
        }
        $first_key = "count";
        $second_key = "capacity";
        $this->builder->where(function ($query) use($parameters, $first_key, $second_key){
           foreach ($parameters as $parameter)
           {
               $parameter = (array) $parameter;
               if (!array_key_exists($first_key, $parameter) ||
                   !array_key_exists($second_key, $parameter)) {
                   logger("Нет необходимых ключей в массиве");
                   return;
               }
               $count = filter_var($parameter[$first_key], FILTER_VALIDATE_INT) ? intval($parameter[$first_key]) : null;
               $capacity = filter_var($parameter[$second_key], FILTER_VALIDATE_INT) ? intval($parameter[$second_key]) : null;
               if($count === null || $capacity === null)
               {
                   continue;
               }
               $query->orWhereHas("module", function ($query) use($count, $capacity){
                   $query->where("capacity_one_ram_mb","=",$capacity)->where("count","=",$count);
               });
           }
        });

    }
    public function timing($parameters): void
    {
        $this->filterRelationByName($parameters, "timing", $this->builder);
    }
    public function memoryTypeFreq($parameters): void
    {
        $parameters = json_decode($parameters, true);
        if (!is_array($parameters)) {
            return;
        }
        $first_key = "name";
        $second_key = "frequency";
        $this->builder->where(function ($query) use($parameters, $first_key, $second_key){
            foreach ($parameters as $parameter)
            {
                $parameter = (array) $parameter;
                if (!array_key_exists($first_key, $parameter) ||
                    !array_key_exists($second_key, $parameter)) {
                    logger("Нет необходимых ключей в массиве");
                    return;
                }
                $name = $parameter[$first_key];
                $frequency = filter_var($parameter[$second_key], FILTER_VALIDATE_INT) ? intval($parameter[$second_key]) : null;
                if($frequency === null)
                {
                    continue;
                }
                $query->orWhereHas("speed.type_memory",function ($query) use($name, $frequency){
                    $query->where("frequencies_memory_with_types.frequency_mhz","=", $frequency)
                        ->where("type_memories.name","=",$name);
                });
            }
        });
    }
    public function eccRegistered($parameters): void
    {
        $this->filterRelationByName($parameters, "ecc_registered_type", $this->builder);
    }
}
