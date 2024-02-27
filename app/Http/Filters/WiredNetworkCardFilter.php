<?php

namespace App\Http\Filters;

class WiredNetworkCardFilter extends QueryFilter
{
    public function manufacturer($manufacturers): void
    {
        $this->builder->whereHas("manufacturer", function ($query) use ($manufacturers)
        {
            if (is_array($manufacturers))
            {
                $query->whereIn("name", $manufacturers);
            }
            elseif (is_string($manufacturers))
            {
                $query->where("name", $manufacturers);
            }
        });
    }
    public function color($colors)
    {
        $this->builder->whereHas("color", function ($query) use ($colors)
        {
            if (is_array($colors))
            {
                $query->whereIn("name", $colors);
            }
            elseif (is_string($colors))
            {
                $query->where("name", $colors);
            }
        });
    }
    public function interface($interfaces)
    {
        $this->builder->whereHas("interface.interface", function ($query) use ($interfaces){
            if (is_array($interfaces))
            {
                $query->whereIn("name", $interfaces);
            }
            elseif (is_string($interfaces))
            {
                $query->where("name", $interfaces);
            }
        });

    }
}
