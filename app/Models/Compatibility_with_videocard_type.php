<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Compatibility_with_videocard_type extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function computer_cases(): BelongsToMany
    {
        return $this->belongsToMany(Computer_case::class,"compatibility_case_with_videocards",
            "compatibility_with_videocard_type_id","computer_case_id");
    }
}
