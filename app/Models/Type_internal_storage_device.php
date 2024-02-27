<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Type_internal_storage_device extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function internal_storage_devices():HasMany
    {
        return $this->hasMany(Internal_storage_device::class, "type_internal_storage_device_id");
    }
}
