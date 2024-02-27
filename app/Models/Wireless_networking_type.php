<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Wireless_networking_type extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function computer_parts(): BelongsToMany
    {
        return $this->belongsToMany(Computer_part::class,"computer_part_wireless_networking_types",
            "wireless_networking_type_id","computer_part_id");
    }
}
