<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Socket extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function cpu_coolers(): BelongsToMany
    {
        return $this->belongsToMany(cpu_cooler::class, "cpu_cooler_cpu_sockets",
            "socket_id","cpu_cooler_id");
    }
    public function CPUs(): HasMany
    {
        return $this->hasMany(cpu::class,"socket_id");
    }
    public function motherboards(): HasMany
    {
        return  $this->hasMany(Motherboard::class, "socket_id");
    }
}
