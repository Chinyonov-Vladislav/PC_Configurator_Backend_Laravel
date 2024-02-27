<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compatibility_case_with_videocard extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function compatibility_videocard_type()
    {
        return $this->belongsTo(Compatibility_with_videocard_type::class, "compatibility_with_videocard_type_id");
    }
}
