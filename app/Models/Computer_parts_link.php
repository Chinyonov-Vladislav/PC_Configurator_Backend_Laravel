<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Computer_parts_link extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function computer_part(): BelongsTo
    {
        return $this->belongsTo(Computer_part::class, "computer_part_id");
    }
    public function computer_case(): HasOne
    {
        return $this->hasOne(Computer_case::class, "link_id");
    }
    public function computer_case_fan(): HasOne
    {
        return $this->hasOne(Computer_case_fan::class, "link_id");
    }
    public function cpu_cooler(): HasOne
    {
        return $this->hasOne(cpu_cooler::class, "link_id");
    }
    public function CPU(): HasOne
    {
        return $this->hasOne(cpu::class,"link_id");
    }
    public function internal_storage_device(): HasOne
    {
        return $this->hasOne(Internal_storage_device::class, "link_id");
    }
    public function motherboard(): HasOne
    {
        return  $this->hasOne(Motherboard::class, "link_id");
    }
    public function optical_drive(): HasOne
    {
        return $this->hasOne(Optical_drive::class,"link_id");
    }
    public function power_supply(): HasOne
    {
        return $this->hasOne(Power_supply::class, "link_id");
    }
    public function ram(): HasOne
    {
        return $this->hasOne(Ram::class,"link_id");
    }
    public function sound_card(): HasOne
    {
        return $this->hasOne(Sound_card::class, "link_id");
    }
    public function graphical_card(): HasOne
    {
        return $this->hasOne(Graphical_card::class,"link_id");
    }
    public function wired_network_card(): HasOne
    {
        return $this->hasOne(Wired_network_card::class, "link_id");
    }

}
