<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Part_number extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function computer_part(): BelongsTo
    {
        return $this->belongsTo(Computer_part::class, "computer_part_link_id");
    }
}
