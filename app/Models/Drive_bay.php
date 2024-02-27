<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Drive_bay extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function computer_cases(): BelongsToMany
    {
        return $this->belongsToMany(Computer_case::class,"computer_case_drive_bays",
            "drive_bay_id","computer_case_id");
    }
}
