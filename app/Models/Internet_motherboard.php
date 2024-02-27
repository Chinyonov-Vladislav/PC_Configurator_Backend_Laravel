<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Internet_motherboard extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function manufacturer(): BelongsTo
    {
        return $this->belongsTo(Manufacturer::class,'manufacturer_id');
    }
    public function motherboards(): BelongsToMany
    {
        return $this->belongsToMany(Motherboard::class,"onboard_internet_motherboards",
            "internet_motherboard_id","motherboard_id");
    }
}
