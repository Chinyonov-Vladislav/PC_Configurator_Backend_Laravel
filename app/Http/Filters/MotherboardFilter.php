<?php

namespace App\Http\Filters;
class MotherboardFilter extends QueryFilter
{
    public function socket($sockets): void
    {
        $this->builder->with("socket")->whereHas("socket", function ($query) use ($sockets) {
            if (is_array($sockets)) {
                $query->whereIn('name', $sockets);
            } elseif (is_string($sockets)) {
                $query->where('name', '=', $sockets);
            }
        });
    }

    public function countSockets($values_count_sockets)
    {
        if (is_array($values_count_sockets)) {
            if (count($values_count_sockets) != 2) {
                return;
            }
            $min_count_sockets = $values_count_sockets[0];
            $max_count_sockets = $values_count_sockets[1];
            $this->builder->whereBetween("count_sockets", [$min_count_sockets, $max_count_sockets]);
        }
        elseif (is_integer($values_count_sockets))
        {
            $this->builder->where("count_sockets", '=', $values_count_sockets);
        }
    }

    public function countMemorySlots($values_count_memory_slots)
    {
        if (is_array($values_count_memory_slots)) {
            if (count($values_count_memory_slots) != 2) {
                return;
            }
            $min_count_memory_slots = $values_count_memory_slots[0];
            $max_count_memory_slots = $values_count_memory_slots[1];
            $this->builder->whereBetween("count_memory_slots", [$min_count_memory_slots, $max_count_memory_slots]);
        }
        elseif (is_integer($values_count_memory_slots))
        {
            $this->builder->where("count_memory_slots", '=', $values_count_memory_slots);
        }
    }

    public function onboardVideo($boolean_onboard_video)
    {
        logger("Onboard VIDEO");
        $this->builder->where("onboard_video", '=', $boolean_onboard_video);
    }

    public function memoryMaxGb($values_min_max_gb)
    {
        if (is_array($values_min_max_gb)) {
            if (count($values_min_max_gb) != 2) {
                return;
            }
            $min_memory_max_gb = $values_min_max_gb[0];
            $max_memory_max_gb = $values_min_max_gb[1];
            $this->builder->whereBetween("memory_max_gb", [$min_memory_max_gb, $max_memory_max_gb]);
        }
        elseif (is_integer($values_min_max_gb))
        {
            $this->builder->where("memory_max_gb", $values_min_max_gb);
        }
    }
    public function manufacturer($manufacturers)
    {
        $this->builder->whereHas("manufacturer", function ($query) use ($manufacturers) {
            if (is_array($manufacturers))
            {
                $query->whereIn('name', $manufacturers);
            }
            elseif (is_string($manufacturers))
            {
                $query->where('name', $manufacturers);
            }
        });
    }
}
