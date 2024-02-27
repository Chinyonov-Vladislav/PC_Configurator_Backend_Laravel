<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ram_ecc_registered_type extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function rams(): HasMany
    {
        return $this->hasMany(Ram::class,"ecc_registered_type_id");
    }
}
