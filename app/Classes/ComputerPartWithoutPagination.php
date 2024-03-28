<?php

namespace App\Classes;

class ComputerPartWithoutPagination
{
    private $hardwareItems;
    private $countComputerPartItems;

    public function __construct($hardwareItems, $countComputerPartItems)
    {
        $this->hardwareItems = $hardwareItems;
        $this->countComputerPartItems = $countComputerPartItems;
    }
    public function getHardwareItems()
    {
        return $this->hardwareItems;
    }
    public function getCountComputerPartItems()
    {
        return $this->countComputerPartItems;
    }
}
