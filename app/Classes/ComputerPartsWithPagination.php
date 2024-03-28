<?php

namespace App\Classes;

class ComputerPartsWithPagination extends ComputerPartWithoutPagination
{
    private $existMoreItems;
    public function __construct($hardwareItems, $countComputerPartItems, $existMoreItems)
    {
        parent::__construct($hardwareItems, $countComputerPartItems);
        $this->existMoreItems = $existMoreItems;
    }
    public function getExistMoreItems()
    {
        return $this->existMoreItems;
    }
}
