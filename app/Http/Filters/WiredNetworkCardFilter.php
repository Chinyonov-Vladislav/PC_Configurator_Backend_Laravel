<?php

namespace App\Http\Filters;

use App\Traits\FilterHelpers;

class WiredNetworkCardFilter extends QueryFilter
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
    public function interface($parameters): void
    {
        $this->filterRelationByName($parameters, "interface", $this->builder);
    }
}
