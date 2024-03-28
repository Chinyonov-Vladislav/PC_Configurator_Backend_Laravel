<?php

namespace App\Http\Filters;

use App\Traits\FilterHelpers;

class CpuCoolerFilter extends QueryFilter
{
    use FilterHelpers;

    public function fanless($parameters): void
    {
        $this->filterByBooleanOrNullValue($parameters,"fanless", $this->builder);
    }
    public function fanRpm($parameters): void
    {
        $name_column_min = 'fan_rpm_min';
        $name_column_max = 'fan_rpm_max';
        $name_column = 'fan_rpm';
        $this->filterMinMaxByThreeColumns($parameters, $name_column_min, $name_column_max, $name_column, $this->builder);
    }
    public function height($parameters): void
    {
        $name_column = 'height_mm';
        $this->filterMinMaxByOneColumn($parameters, $name_column, $this->builder);
    }
    public function noiseLevel($parameters): void
    {
        $name_column_min = 'noise_level_min';
        $name_column_max = 'noise_level_max';
        $name_column = 'noise_level';
        $this->filterMinMaxByThreeColumns($parameters, $name_column_min, $name_column_max, $name_column, $this->builder);
    }
    public function radiatorSize($parameters): void
    {
        $name_column = 'radiator_size';
        $this->filterMinMaxByOneColumn($parameters, $name_column, $this->builder);
    }
    public function waterCooled($parameters): void
    {
        $this->filterByBooleanOrNullValue($parameters,"water_cooled", $this->builder);
    }
    public function manufacturer($parameters): void
    {
        $this->filterRelationByName($parameters, "manufacturer", $this->builder);
    }
    public function color($parameters): void
    {
        $this->filterRelationByName($parameters, "color", $this->builder);
    }
    public function bearingType($parameters): void
    {
        $this->filterRelationByName($parameters, "bearing_type", $this->builder);
    }
    public function socket($parameters): void
    {
        $this->filterRelationByName($parameters, "sockets", $this->builder);
    }
}
