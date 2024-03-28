<?php

namespace App\Http\Filters;

use App\Traits\FilterHelpers;

class WifiCardFilter extends QueryFilter
{
    use FilterHelpers;
    public function manufacturer($parameters): void
    {
        $this->filterRelationByName($parameters, "manufacturer", $this->builder);
    }
    public function color($parameters): void
    {
        $this->filterRelationByName($parameters, "color", $this->builder);
    }
    public function protocol($parameters): void
    {
        $this->filterRelationByName($parameters, "protocol", $this->builder);
    }
    public function operatingRange($parameters): void
    {
        $this->filterRelationByName($parameters, "operating_range", $this->builder);
    }
    public function interface($parameters): void
    {
        $this->filterRelationByName($parameters, "interface", $this->builder);
    }
    public function antenna($parameters): void
    {
        $this->filterRelationByName($parameters, "antenna", $this->builder);
    }

}
