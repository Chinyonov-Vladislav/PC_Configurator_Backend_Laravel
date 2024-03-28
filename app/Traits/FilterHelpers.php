<?php

namespace App\Traits;

trait FilterHelpers
{
    private string $name_first_key = "min";
    private string $name_second_key = "max";

    private function convertStrValueToIntegerOrFloat($min_str): float|int|null
    {
        return filter_var($min_str, FILTER_VALIDATE_INT) ? intval($min_str) :
            (filter_var($min_str, FILTER_VALIDATE_FLOAT) ? floatval($min_str) : null);
    }

    public function filterMinMaxByThreeColumns($parameters, $name_column_min, $name_column_max, $name_column, $builder): void
    {
        logger("INFO -> ".$name_column);
        logger($parameters);
        $parameters = json_decode($parameters, true); // возможно исправить
        logger(gettype($parameters));
        if (is_array($parameters)) {
            if (!array_key_exists($this->name_first_key, $parameters) || !array_key_exists($this->name_second_key, $parameters)) {
                logger("Нет необходимых ключей в массиве");
                return;
            }
            $min_value = $this->convertStrValueToIntegerOrFloat($parameters[$this->name_first_key]);
            $max_value = $this->convertStrValueToIntegerOrFloat($parameters[$this->name_second_key]);
            $builder->where(function ($query) use ($min_value, $max_value, $name_column_min, $name_column_max, $name_column) {
                $query->where(function ($query) use ($min_value, $max_value, $name_column_min, $name_column_max, $name_column) {
                    $query->where($name_column_min, '>=', $min_value)
                        ->where($name_column_max, '<=', $max_value)
                        ->whereNull($name_column);
                })->orWhere(function ($query) use ($min_value, $max_value, $name_column_min, $name_column_max, $name_column) {
                    $query->whereBetween($name_column, [$min_value, $max_value])
                        ->whereNull($name_column_min)
                        ->whereNull($name_column_max);
                });
            });
        } else {
            $parameter_value = $this->convertStrValueToIntegerOrFloat($parameters);
            if ($parameter_value === null) {
                return;
            }
            $builder->where($name_column, $parameter_value)->whereNotNull($name_column);
        }
    }

    public function filterMinMaxByOneColumn($parameters, $name_column, $builder): void
    {
        $parameters = json_decode($parameters); // возможно исправить
        if (is_array($parameters)) {
            if (!array_key_exists($this->name_first_key, $parameters) || !array_key_exists($this->name_second_key, $parameters)) {
                logger("Нет необходимых ключей в массиве");
                return;
            }
            $min_value = $this->convertStrValueToIntegerOrFloat($parameters[$this->name_first_key]);
            $max_value = $this->convertStrValueToIntegerOrFloat($parameters[$this->name_second_key]);
            $builder->where(function ($query) use ($min_value, $max_value, $name_column) {
                $query->where($name_column, '>=', $min_value)
                    ->where($name_column, '<=', $max_value);
            });
        } else {
            $parameter_value = $this->convertStrValueToIntegerOrFloat($parameters);
            if ($parameter_value === null) {
                return;
            }
            $this->builder->where($parameter_value, $parameter_value)->whereNotNull($parameter_value);
        }
    }
    public function filterByBooleanOrNullValue($parameters, $name_column, $builder): void
    {
        $parameters = json_decode($parameters); // возможно исправить
        $allowedValues =[true, false, null];
        if(!is_array($parameters)) {
            if(!in_array($parameters, $allowedValues))
            {
                return;
            }
            $builder->where($name_column, "=", $parameters);
        }
        else
        {
            $builder->where(function ($query) use($parameters, $name_column, $allowedValues){
                foreach ($parameters as $parameter)
                {
                    # TODO проверить корректность работы
                    /*logger("PARAMETER = ".$parameter);
                    if (filter_var($parameter, FILTER_VALIDATE_BOOLEAN)) {
                        $converted_parameter = boolval($parameter);
                    } elseif ($parameter === "null") {
                        $converted_parameter = null;
                    } else {
                        continue;
                    }

                    logger("CONVERTED PARAMETER = ".$converted_parameter);*/
                    if(!in_array($parameter, $allowedValues))
                    {
                        continue;
                    }
                    $query->orWhere($name_column, "=", $parameter);
                }
            });
        }
    }
    public function filterRelationByName($parameters, $name_relation, $builder)
    {
        $parameters = json_decode($parameters);
        if (!is_array($parameters) && !is_string($parameters)) {
            return;
        }
        $builder->whereHas($name_relation, function ($query) use ($parameters){
            if (is_array($parameters))
            {
                $query->whereIn("name", $parameters);
            }
            elseif (is_string($parameters))
            {
                $query->where("name", $parameters);
            }
        });
    }
}
