<?php

namespace App\Http\Filters;

use App\Traits\FilterHelpers;

class PowerSupplyFilter extends QueryFilter
{
    use FilterHelpers;

    public function wattage($parameters): void
    {
        $this->filterMinMaxByOneColumn($parameters, "wattage_w", $this->builder);
    }

    public function length($parameters): void
    {
        $this->filterMinMaxByOneColumn($parameters, "length_mm", $this->builder);
    }

    public function efficiencyPercent($parameters): void
    {
        $this->filterMinMaxByOneColumn($parameters, "efficiency_percent", $this->builder);
    }

    public function fanless($parameters): void
    {
        $this->filterByBooleanOrNullValue($parameters, "", $this->builder);
    }

    public function manufacturer($parameters): void
    {
        $this->filterRelationByName($parameters, "manufacturer", $this->builder);
    }

    public function color($parameters): void
    {
        $this->filterRelationByName($parameters, "color", $this->builder);
    }

    public function efficiencyRating($parameters): void
    {
        $this->filterRelationByName($parameters, "efficiency_rating", $this->builder);
    }

    public function modularType($parameters): void
    {
        $this->filterRelationByName($parameters, "modular_type", $this->builder);
    }

    public function formFactor($parameters): void
    {
        $this->filterRelationByName($parameters, "form_factor", $this->builder);
    }

    public function output($parameters): void
    {
        $this->filterRelationByName($parameters, "outputs", $this->builder);
    }

    public function connector($parameters): void
    {
        $parameters = json_decode($parameters, true);
        if (!is_array($parameters)) {
            return;
        }
        $first_key = "name";
        $second_key = "min";
        $third_key = "max";
        $this->builder->where(function ($query) use ($parameters, $first_key, $second_key, $third_key) {
            foreach ($parameters as $parameter) {
                $parameter = (array) $parameter;
                if (!array_key_exists($first_key, $parameter) ||
                    !array_key_exists($second_key, $parameter) ||
                    !array_key_exists($third_key, $parameter)) {
                    logger("Нет необходимых ключей в массиве");
                    return;
                }
                $name = $parameter[$first_key];
                $min = $parameter[$second_key];
                $max = $parameter[$third_key];
                $query->whereHas("connectors", function ($query) use ($name, $min, $max) {
                    $query->where("name", "=", $name)->whereBetween("power_supply_connectors.count", [$min, $max]);
                });
            }
        });
    }
}
