<?php

namespace App\Models;

use App\Http\Filters\Filterable;
use App\Http\Resources\FullVersionComputerPart\FullVersionOpticalDriveResource;
use App\Interfaces\QueryableAdditionalWithInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Query\Builder;

class Optical_drive extends Model implements QueryableAdditionalWithInterface
{
    use Filterable;
    use HasFactory;
    protected $guarded = [];
    public function color(): BelongsTo
    {
        return $this->belongsTo(Color::class, "color_id");
    }
    public function manufacturer(): BelongsTo
    {
        return $this->belongsTo(Manufacturer::class, "manufacturer_id");
    }
    public function form_factor(): BelongsTo
    {
        return $this->belongsTo(Form_factor::class, "form_factor_id");
    }
    public function interface(): BelongsTo
    {
        return $this->belongsTo(Computer_interface::class, "interface_id");
    }
    public function link(): BelongsTo
    {
        return $this->belongsTo(Computer_parts_link::class, "link_id");
    }
    public function checkExistById($id): bool
    {
        return $this::query()->where('id', $id)->exists();
    }

    public function ratings()
    {
        return $this->morphMany(Rating::class, 'ratingable', "ratingable_type","ratingable_id");
    }
    public function getItemById($id): FullVersionOpticalDriveResource
    {
        /*$hidden_columns = ["color_id",
            "manufacturer_id",
            "form_factor_id",
            "interface_id",
            "link_id",
            "created_at",
            "updated_at",];*/
        $item = $this->addWithToQuery($this::query())
            ->where("id", "=",$id)
            ->first();
        return new FullVersionOpticalDriveResource($item);
    }

    public static function addWithToQuery($query)
    {
        $query->with([
        "color"=>function ($query) {
            $query->select("id", "name");
        },
        "manufacturer"=>function ($query) {
            $query->select("id", "name");
        },
        "form_factor"=>function ($query) {
            $query->select("id", "name");
        },
        "interface"=>function ($query) {
            $query->select("id", "name");
        }]);
        return $query;
    }
}
