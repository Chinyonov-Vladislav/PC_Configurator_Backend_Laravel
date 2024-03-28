<?php

namespace App\Http\Filters;

use App\Traits\FilterHelpers;

class OpticalDriveFilter extends QueryFilter
{
    use FilterHelpers;

    public function bufferCache($parameters): void
    {
        $this->filterMinMaxByOneColumn($parameters, "buffer_cache_mb", $this->builder);
    }

    public function bdMinusRomSpeed($parameters): void
    {
        $this->filterMinMaxByOneColumn($parameters, "bd_minus_rom_speed", $this->builder);
    }

    public function dvdMinusRomSpeed($parameters): void
    {
        $this->filterMinMaxByOneColumn($parameters, "dvd_minus_rom_speed", $this->builder);
    }

    public function cdMinusRomSpeed($parameters): void
    {
        $this->filterMinMaxByOneColumn($parameters, "cd_minus_rom_speed", $this->builder);
    }

    public function bdMinusRSpeed($parameters): void
    {
        $this->filterMinMaxByOneColumn($parameters, "bd_minus_r_Speed", $this->builder);
    }

    public function bdMinusRDualLayerSpeed($parameters): void
    {
        $this->filterMinMaxByOneColumn($parameters, "bd_minus_r_dual_layer_speed", $this->builder);
    }

    public function bdMinusReSpeed($parameters): void
    {
        $this->filterMinMaxByOneColumn($parameters, "bd_minus_re_speed", $this->builder);
    }

    public function bdMinusReDualLayerSpeed($parameters): void
    {
        $this->filterMinMaxByOneColumn($parameters, "bd_minus_re_dual_layer_speed", $this->builder);
    }

    public function dvdPlusRSpeed($parameters): void
    {
        $this->filterMinMaxByOneColumn($parameters, "dvd_plus_r_speed", $this->builder);
    }

    public function dvdPlusRwSpeed($parameters): void
    {
        $this->filterMinMaxByOneColumn($parameters, "dvd_plus_rw_speed", $this->builder);
    }

    public function dvdPlusRDualLayerSpeed($parameters): void
    {
        $this->filterMinMaxByOneColumn($parameters, "dvd_plus_r_dual_layer_speed", $this->builder);
    }

    public function dvdMinusRwSpeed($parameters): void
    {
        $this->filterMinMaxByOneColumn($parameters, "dvd_minus_rw_speed", $this->builder);
    }

    public function dvdMinusRDualLayerSpeed($parameters): void
    {
        $this->filterMinMaxByOneColumn($parameters, "dvd_minus_r_dual_layer_speed", $this->builder);
    }

    public function dvdMinusRamSpeed($parameters): void
    {
        $this->filterMinMaxByOneColumn($parameters, "dvd_minus_ram_speed", $this->builder);
    }

    public function cdMinusRSpeed($parameters): void
    {
        $this->filterMinMaxByOneColumn($parameters, "cd_minus_r_speed", $this->builder);
    }

    public function cdMinusRwSpeed($parameters): void
    {
        $this->filterMinMaxByOneColumn($parameters, "cd_minus_rw_speed", $this->builder);
    }

    public function dvdMinusRSpeed($parameters): void
    {
        $this->filterMinMaxByOneColumn($parameters, "dvd_minus_r_speed", $this->builder);
    }

    public function manufacturer($parameters): void
    {
        $this->filterRelationByName($parameters, "manufacturer", $this->builder);
    }

    public function color($parameters): void
    {
        $this->filterRelationByName($parameters, "color", $this->builder);
    }

    public function formFactor($parameters): void
    {
        $this->filterRelationByName($parameters, "form_factor", $this->builder);
    }

    public function interface($parameters): void
    {
        $this->filterRelationByName($parameters, "interface", $this->builder);
    }
}
