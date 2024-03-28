<?php

namespace App\Traits;

use App\Models\Color;
use App\Models\Computer_part;
use App\Models\Manufacturer;
use stdClass;

trait HelpersGetValuesParaneters
{
    public function get_computer_part_from_database($name_part_pc)
    {
        return Computer_part::query()->where("name", $name_part_pc)
            ->select("id")
            ->first();
    }
    public function get_manufacturers($name_relation)
    {
        return Manufacturer::query()->whereHas($name_relation, function($query){
            $query->whereNotNull('manufacturer_id');
        })->select(['id', 'name'])->get();
    }
    public function get_colors($name_relation)
    {
        return Color::query()->whereHas($name_relation, function ($query){
            $query->whereNotNull('color_id');
        })->select(['id', 'name'])->get();
    }
    public function get_parameters_for_boolean_nullable_variable()
    {
        $parameters = new stdClass();
        $parameters->variant1 = true;
        $parameters->variant2 = false;
        $parameters->variant3 = null;
        return $parameters;
    }
    public function find_min_max_value_for_column(string $modelClassName, string $name_column)
    {
        $parameters = new stdClass();
        $parameters->min = $modelClassName::query()->min($name_column);
        $parameters->max = $modelClassName::query()->max($name_column);
        return $parameters;
    }
    public function find_min_max_value_from_min_max_value_column(string $modelClassName, $name_min_column, $name_max_column, $name_column)
    {
        $min_value_from_min_column = $modelClassName::query()->min($name_min_column);
        $min_value_from_column = $modelClassName::query()->min($name_column);

        $max_value_from_max_column = $modelClassName::query()->max($name_max_column);
        $max_value_from_column = $modelClassName::query()->max($name_column);

        $parameters= new stdClass();
        // возможно добавить проверка на то, что значения null
        $parameters->min = ($min_value_from_min_column === null ||
            ($min_value_from_column !== null && $min_value_from_min_column > $min_value_from_column))
            ? $min_value_from_column
            : $min_value_from_min_column;
        $parameters->max = ($max_value_from_column === null ||
            $max_value_from_max_column !==null && $max_value_from_max_column > $max_value_from_column)
            ? $max_value_from_max_column
            : $max_value_from_column;
        return $parameters;
    }
}
