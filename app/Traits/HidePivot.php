<?php

namespace App\Traits;

trait HidePivot
{
    public function hidePivotField($collection): void
    {
        $collection->each(function ($item) {
            $item->makeHidden('pivot');
        });
    }
}
