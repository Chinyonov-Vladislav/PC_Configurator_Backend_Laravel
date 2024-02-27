<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Frame_sync_type extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function graphical_cards(): HasMany
    {
        return $this->hasMany(Graphical_card::class,"frame_sync_type_id");
    }
}
