<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Form_factor extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function computer_parts(): BelongsToMany
    {
        return $this->belongsToMany(Computer_part::class, "computer_part_form_factors",'form_factor_id','computer_part_id');
    }
}
