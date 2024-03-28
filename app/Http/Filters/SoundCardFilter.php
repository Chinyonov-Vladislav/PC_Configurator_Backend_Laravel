<?php

namespace App\Http\Filters;

use App\Traits\FilterHelpers;

class SoundCardFilter extends QueryFilter
{
    use FilterHelpers;
    public function sampleRate($parameters): void
    {
        $this->filterMinMaxByOneColumn($parameters, "value_sample_rate_hz",$this->builder);
    }
    public function signalNoiseRatio($parameters): void
    {
        $this->filterMinMaxByOneColumn($parameters, "signal_to_noise_ratio",$this->builder);
    }
    public function manufacturer($parameters): void
    {
        $this->filterRelationByName($parameters, "manufacturer", $this->builder);
    }
    public function color($parameters): void
    {
        $this->filterRelationByName($parameters, "color", $this->builder);
    }
    public function chipset($parameters): void
    {
        $this->filterRelationByName($parameters, "chipset", $this->builder);
    }
    public function channel($parameters): void
    {
        $this->filterRelationByName($parameters, "channel", $this->builder);
    }
    public function bitDepth($parameters): void
    {
        $this->filterRelationByName($parameters, "sound_card_bit_depth", $this->builder);
    }
    public function interface($parameters): void
    {
        $this->filterRelationByName($parameters, "interface", $this->builder);
    }
}
