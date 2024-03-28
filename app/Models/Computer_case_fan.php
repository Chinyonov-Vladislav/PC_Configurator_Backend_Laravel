<?php

namespace App\Models;

use App\Http\Filters\Filterable;
use App\Http\Resources\FullVersionComputerPart\FullVersionCaseFanResource;
use App\Interfaces\QueryableAdditionalWithInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Computer_case_fan extends Model implements QueryableAdditionalWithInterface
{
    use HasFactory;
    use Filterable;
    protected $guarded = [];
    protected $casts = [
        'pmw' => 'boolean',
    ];
    protected $appends = ['pmw'];
    public function manufacturer(): BelongsTo
    {
        return $this->belongsTo(Manufacturer::class,"manufacturer_id");
    }
    public function color(): BelongsTo
    {
        return $this->belongsTo(Color::class,"color_id");
    }
    public function connector(): BelongsTo
    {
        return $this->belongsTo(Connector::class,"connector_id");
    }
    public function controller(): BelongsTo
    {
        return $this->belongsTo(Controller::class,"controller_id");
    }
    public function led(): BelongsTo
    {
        return $this->belongsTo(Led::class,"led_id");
    }
    public function bearing_type(): BelongsTo
    {
        return $this->belongsTo(Bearing_type::class,"bearing_type_id");
    }
    public function link(): BelongsTo
    {
        return $this->belongsTo(Computer_parts_link::class,"link_id");
    }
    public function ratings()
    {
        return $this->morphMany(Rating::class, 'ratingable', "ratingable_type","ratingable_id");
    }
    public function checkExistById($id): bool
    {
        return $this::query()->where('id', $id)->exists();
    }
    public function getItemById($id): FullVersionCaseFanResource
    {
        /*$hidden_columns = ["manufacturer_id","color_id","connector_id","controller_id","led_id","bearing_type_id", "link_id","created_at","updated_at"];
        return $this->addWithToQuery($this::query())
            ->where("id", "=", $id)
            ->first()
            ->makeHidden($hidden_columns);*/
        $item = $this->addWithToQuery($this::query())
            ->where("id", "=", $id)
            ->first();
        return new FullVersionCaseFanResource($item);
    }
    public static function addWithToQuery($query)
    {
        $query->with(["manufacturer"=> function ($query) {
            $query->select('id', 'name');},
            "color"=> function ($query) {
                $query->select('id', 'name');},
            "connector"=> function ($query) {
                $query->select('id', 'name');},
            "controller"=> function ($query) {
                $query->select('id', 'name');},
            "led"=> function ($query) {
                $query->select('id', 'name');},
            "bearing_type"=> function ($query) {
                $query->select('id', 'name');}]);
        return $query;
    }
}
