<?php

namespace App\Http\Filters;
use App\Traits\FilterHelpers;

class CaseFanFilter extends QueryFilter
{
    use FilterHelpers;
    public function airflow($parameters): void
    {
        $name_column_min = 'airflow_min';
        $name_column_max = 'airflow_max';
        $name_column = 'airflow';
        $this->filterMinMaxByThreeColumns($parameters, $name_column_min, $name_column_max, $name_column, $this->builder);
    }

    public function noiseLevel($parameters): void
    {
        $name_column_min = 'noise_level_min';
        $name_column_max = 'noise_level_max';
        $name_column = 'noise_level';
        $this->filterMinMaxByThreeColumns($parameters, $name_column_min, $name_column_max, $name_column, $this->builder);
    }

    public function rpm($parameters): void
    {
        $name_column_min = 'rpm_min';
        $name_column_max = 'rpm_max';
        $name_column = 'rpm';
        $this->filterMinMaxByThreeColumns($parameters, $name_column_min, $name_column_max, $name_column, $this->builder);
    }

    public function pmw($parameters): void
    {
        $this->filterByBooleanOrNullValue($parameters,"pmw", $this->builder);
    }
    public function size($parameters): void
    {
        $name_column = 'size_mm';
        $this->filterMinMaxByOneColumn($parameters, $name_column, $this->builder);
    }
    public function staticPressure($parameters): void
    {
        $name_column = "static_pressure";
        $this->filterMinMaxByOneColumn($parameters, $name_column, $this->builder);
    }
    public function quantityInPack($parameters): void
    {
        $name_column = "quantity_in_pack";
        $this->filterMinMaxByOneColumn($parameters, $name_column, $this->builder);
    }
    public function manufacturer($parameters): void
    {
        $this->filterRelationByName($parameters, "manufacturer", $this->builder);
    }
    public function color($parameters): void
    {
        $this->filterRelationByName($parameters, "color", $this->builder);
    }
    public function connector($parameters): void
    {
        $this->filterRelationByName($parameters, "connector", $this->builder);
    }
    public function controller($parameters): void
    {
        $this->filterRelationByName($parameters, "controller", $this->builder);
    }
    public function led($parameters): void
    {
        $this->filterRelationByName($parameters, "led", $this->builder);

    }
    public function bearingType($parameters): void
    {
        $this->filterRelationByName($parameters, "bearing_type", $this->builder);
    }
}
