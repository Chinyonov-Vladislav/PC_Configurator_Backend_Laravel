<?php

namespace App\Http\Filters;
use App\Traits\FilterHelpers;

class CaseFilter extends QueryFilter
{
    use FilterHelpers;

    public function volume($parameters): void
    {
        $name_column = "volume";
        $this->filterMinMaxByOneColumn($parameters, $name_column, $this->builder);
    }

    public function dimensionLength($parameters): void
    {
        $name_column = "dimension_length";
        $this->filterMinMaxByOneColumn($parameters, $name_column, $this->builder);
    }

    public function dimensionWidth($parameters): void
    {
        $name_column = "dimension_width";
        $this->filterMinMaxByOneColumn($parameters, $name_column, $this->builder);
    }

    public function dimensionHeight($parameters): void
    {
        $name_column = "dimension_height";
        $this->filterMinMaxByOneColumn($parameters, $name_column, $this->builder);
    }

    public function color($parameters): void
    {
        $this->filterRelationByName($parameters, "color", $this->builder);
    }

    public function manufacturer($parameters): void
    {
        $this->filterRelationByName($parameters, "manufacturer", $this->builder);
    }

    public function sidePanel($parameters): void
    {
        $this->filterRelationByName($parameters, "side_panel", $this->builder);
    }

    public function formFactor($parameters): void
    {
        $this->filterRelationByName($parameters, "form_factor", $this->builder);
    }

    public function graphicCardCompatibility($parameters): void
    {
        $parameters = json_decode($parameters, true);
        if (!is_array($parameters)) {
            return;
        }
        $this->builder->where(function ($query) use($parameters){
            foreach ($parameters as $parameter_array) {
                $parameter_array = (array) $parameter_array;
                if (!array_key_exists($this->name_first_key, $parameter_array) || !array_key_exists($this->name_second_key, $parameter_array) || !array_key_exists("name", $parameter_array)) {
                    logger("Нет необходимых ключей в массиве");
                    continue;
                }
                $name = $parameter_array["name"] === "null" ? null : $parameter_array["name"];
                $min_value = $this->convertStrValueToIntegerOrFloat($parameter_array[$this->name_first_key]);
                $max_value = $this->convertStrValueToIntegerOrFloat($parameter_array[$this->name_second_key]);
                logger("-----\nName = $name\nMinValue = $min_value\nMaxValue = $max_value");
                $query->orWhere(function ($query) use ($name, $min_value, $max_value) {
                    if ($name !== null) {
                        $query->whereHas("compatibility_with_videocard_types", function ($query) use ($name, $min_value, $max_value) {
                            $query->where("compatibility_with_videocard_types.name", "=", $name)
                                ->whereBetween("compatibility_case_with_videocards.maximum_length_videocard_in_mm", [$min_value, $max_value]);
                        });
                    } else {
                        $query->whereHas("compatibility_with_videocard_without_type", function ($query) use ($min_value, $max_value) {
                            $query->whereBetween("compatibility_case_with_videocards.maximum_length_videocard_in_mm", [$min_value, $max_value]);
                        });
                    }
                });
            }
        });
    }

    public function port($parameters): void
    {
        $this->filterRelationByName($parameters, "ports", $this->builder);
    }

    public function expansionSlot($parameters): void
    {
        $parameters = json_decode($parameters, true);
        logger(json_encode($parameters));
        if (!is_array($parameters)) {
            return;
        }
        $this->builder->where(function ($query) use($parameters){
            foreach ($parameters as $parameter_array) {
                $parameter_array = (array) $parameter_array;
                if (!array_key_exists($this->name_first_key, $parameter_array) ||
                    !array_key_exists($this->name_second_key, $parameter_array) ||
                    !array_key_exists("name", $parameter_array)) {
                    logger("Нет необходимых ключей в массиве");
                    continue;
                }
                $name = $parameter_array["name"] === "null" ? null : $parameter_array["name"];
                $min_value = $this->convertStrValueToIntegerOrFloat($parameter_array[$this->name_first_key]);
                $max_value = $this->convertStrValueToIntegerOrFloat($parameter_array[$this->name_second_key]);
                $query->orWhere(function ($query) use($name, $min_value, $max_value){
                    $query->whereHas("expansion_slots", function ($query) use($name, $min_value, $max_value){
                        $query->where("name", $name)->whereBetween("computer_case_expansion_slots.count",[$min_value, $max_value]);
                    });
                });
            }
        });


        /*$this->builder->orWhere(function ($query) use ($parameters) {
            foreach ($parameters as $parameter_array) {
                if (!array_key_exists($this->name_first_key, $parameter_array) ||
                    !array_key_exists($this->name_second_key, $parameter_array) ||
                    !array_key_exists("name", $parameter_array)) {
                    logger("Нет необходимых ключей в массиве");
                    continue;
                }
                $name = $parameter_array["name"];
                $min_value = $this->convertStrValueToIntegerOrFloat($parameter_array[$this->name_first_key]);
                $max_value = $this->convertStrValueToIntegerOrFloat($parameter_array[$this->name_second_key]);
                $query->whereHas("expansion_slots", function ($query) use ($name, $min_value, $max_value) {
                    $query->where("name", $name)->whereBetween("computer_case_expansion_slots.count", [$min_value, $max_value]);
                });
            }
        });*/

        /*$this->builder->whereHas("expansion_slots", function ($query) use ($parameters) {
            if (is_array($parameters))
            {
                $query->whereIn('name', $parameters);
            }
            elseif (is_string($parameters))
            {
                $query->where('name', $parameters);
            }
        });*/
    }

    public function driveBay($parameters): void
    {
        $parameters = json_decode($parameters, true);
        if (!is_array($parameters)) {
            return;
        }
        $this->builder->where(function ($query) use($parameters){
            foreach ($parameters as $parameter_array) {
                $parameter_array = (array) $parameter_array;
                if (!array_key_exists($this->name_first_key, $parameter_array) ||
                    !array_key_exists($this->name_second_key, $parameter_array) ||
                    !array_key_exists("name", $parameter_array)) {
                    logger("Нет необходимых ключей в массиве");
                    continue;
                }
                $name = $parameter_array["name"];
                $min_value = $this->convertStrValueToIntegerOrFloat($parameter_array[$this->name_first_key]);
                $max_value = $this->convertStrValueToIntegerOrFloat($parameter_array[$this->name_second_key]);
                $query->orWhere(function ($query) use($name, $min_value, $max_value){
                    $query->whereHas("drive_bays", function ($query) use($name, $min_value, $max_value){
                        $query->where("name", $name)->whereBetween("computer_case_drive_bays.count",[$min_value, $max_value]);
                    });
                });
            }
        });

    }
}
