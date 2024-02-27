<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Side_panel extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function computer_cases(): HasMany
    {
        return $this->hasMany(Computer_case::class, "side_panel_id");
    }
}
