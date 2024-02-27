<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Computer_part_interface extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function interface(): BelongsTo
    {
        return $this->belongsTo(Computer_interface::class, "computer_interface_id");
    }
    public function internal_storage_devices(): HasMany
    {
        return $this->hasMany(Internal_storage_device::class, "interface_id");
    }
    public function motherboards(): BelongsToMany
    {
        return $this->belongsToMany(Motherboard::class, "motherboard_interfaces",
            "interface_id","motherboard_id");
    }
    public function optical_drives(): HasMany
    {
        return $this->hasMany(Optical_drive::class,"interface_id");
    }
    public function sound_cards(): HasMany
    {
        return $this->hasMany(Sound_card::class, "interface_id");
    }
    public function graphical_cards(): HasMany
    {
        return $this->hasMany(Graphical_card::class,"interface_id");
    }
    public function wired_network_cards(): HasMany
    {
        return $this->hasMany(Wired_network_card::class, "interface_id");
    }
}
