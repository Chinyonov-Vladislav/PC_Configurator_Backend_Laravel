<?php

namespace App\Http\Filters;

use App\Traits\FilterHelpers;

class StorageDeviceFilter extends QueryFilter
{
    use FilterHelpers;
    public function cache($parameters): void
    {
        $this->filterMinMaxByOneColumn($parameters, "cache_mb",$this->builder);
    }
    public function capacity($parameters): void
    {
        $this->filterMinMaxByOneColumn($parameters, "capacity_gb",$this->builder);
    }
    public function priceGb($parameters): void
    {
        $this->filterMinMaxByOneColumn($parameters, "price_for_gb",$this->builder);
    }
    public function nvme($parameters): void
    {
        $this->filterByBooleanOrNullValue($parameters, "nvme",$this->builder);
    }
    public function fullDiskWriteThroughput($parameters): void
    {
        $this->filterMinMaxByOneColumn($parameters, "full_disk_write_throughput_mb_s",$this->builder);
    }
    public function fullDiskWriteThroughputLast10Seconds($parameters): void
    {
        $this->filterMinMaxByOneColumn($parameters, "full_disk_write_throughput_last_10_seconds_mb_s",$this->builder);
    }
    public function randomReadThroughputDisk50Full($parameters): void
    {
        $this->filterMinMaxByOneColumn($parameters, "random_read_throughput_disk_50_full",$this->builder);
    }
    public function randomWriteThroughputDisk50Full($parameters): void
    {
        $this->filterMinMaxByOneColumn($parameters, "random_write_throughput_disk_50_full",$this->builder);
    }
    public function sequentialReadThroughputDisk50Full($parameters): void
    {
        $this->filterMinMaxByOneColumn($parameters, "sequential_read_throughput_disk_50_full",$this->builder);
    }
    public function sequentialWriteThroughputDisk50Full($parameters): void
    {
        $this->filterMinMaxByOneColumn($parameters, "sequential_write_throughput_disk_50_full",$this->builder);
    }
    public function powerLossProtection($parameters): void
    {
        $this->filterByBooleanOrNullValue($parameters, "power_loss_protection",$this->builder);
    }
    public function hybridSsdCache($parameters): void
    {
        $this->filterMinMaxByOneColumn($parameters, "hybrid_ssd_cache_mb",$this->builder);
    }
    public function rpm($parameters): void
    {
        $this->filterMinMaxByOneColumn($parameters, "rpm",$this->builder);
    }

    public function manufacturer($parameters): void
    {
        $this->filterRelationByName($parameters, "manufacturer", $this->builder);
    }
    public function formFactor($parameters): void
    {
        $this->filterRelationByName($parameters, "form_factor", $this->builder);
    }
    public function interface($parameters): void
    {
        $this->filterRelationByName($parameters, "interface", $this->builder);
    }
    public function ssdController($parameters): void
    {
        $this->filterRelationByName($parameters, "ssd_controller", $this->builder);
    }
    public function typeInternalStorageDevice($parameters): void
    {
        $this->filterRelationByName($parameters, "type_internal_storage_device", $this->builder);
    }
    public function ssdNandFlashType($parameters): void
    {
        $this->filterRelationByName($parameters, "ssd_nand_flash_type", $this->builder);
    }
}
