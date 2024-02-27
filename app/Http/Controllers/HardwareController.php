<?php

namespace App\Http\Controllers;

use App\Http\Filters\CaseFanFilter;
use App\Http\Filters\CaseFilter;
use App\Http\Filters\CpuCoolerFilter;
use App\Http\Filters\CpuFilter;
use App\Http\Filters\GraphicCardFilter;
use App\Http\Filters\MotherboardFilter;
use App\Http\Filters\OpticalDriveFilter;
use App\Http\Filters\PowerSupplyFilter;
use App\Http\Filters\RamMemoryFilter;
use App\Http\Filters\SoundCardFilter;
use App\Http\Filters\StorageDeviceFilter;
use App\Http\Filters\WifiCardFilter;
use App\Http\Filters\WiredNetworkCardFilter;
use App\Models\Computer_case;
use App\Models\Computer_case_fan;
use App\Models\cpu;
use App\Models\cpu_cooler;
use App\Models\Graphical_card;
use App\Models\Internal_storage_device;
use App\Models\Motherboard;
use App\Models\Optical_drive;
use App\Models\Power_supply;
use App\Models\Ram;
use App\Models\Sound_card;
use App\Models\Wifi_card;
use App\Models\Wired_network_card;

class HardwareController extends Controller
{
    public function get_case_fans(CaseFanFilter $filter)
    {
        $computer_case_fans = Computer_case_fan::filter($filter)->get();
        return response()->json(["computer_case_fans"=>$computer_case_fans]);
    }
    public function get_cases(CaseFilter $filter)
    {
        $cases = Computer_case::filter($filter)->get();
        return response()->json(["cases"=>$cases]);
    }
    public function get_cpu_coolers(CpuCoolerFilter $filter)
    {
        $cpu_coolers = cpu_cooler::filter($filter)->get();
        return response()->json(["cpu_coolers"=>$cpu_coolers]);
    }
    public function get_cpus(CpuFilter $filter)
    {
        $cpu = cpu::filter($filter)->get();
        return response()->json(["cpu"=>$cpu]);
    }
    public function get_graphic_cards(GraphicCardFilter $filter)
    {
        $graphic_cards = Graphical_card::filter($filter)->get();
        return response()->json(["graphic_cards"=>$graphic_cards]);
    }
    public function get_storage_devices(StorageDeviceFilter $filter)
    {
        $storage_devices = Internal_storage_device::filter($filter)->get();
        return response()->json(["storage_devices"=>$storage_devices]);
    }
    public function get_motherboards(MotherboardFilter $filter)
    {
        $motherboards = Motherboard::filter($filter)->get();
        return response()->json(["motherboards"=>$motherboards]);
    }
    public function get_optical_drives(OpticalDriveFilter $filter)
    {
        $optical_drives = Optical_drive::filter($filter)->get();
        return response()->json(["optical_drives"=>$optical_drives]);
    }
    public function get_power_supplies(PowerSupplyFilter $filter)
    {
        $power_supplies = Power_supply::filter($filter)->get();
        return response()->json(["power_supplies"=>$power_supplies]);
    }
    public function get_ram_memories(RamMemoryFilter $filter)
    {
        $rams = Ram::filter($filter)->get();
        return response()->json(["rams"=>$rams]);
    }
    public function get_sound_cards(SoundCardFilter $filter)
    {
        $sound_cards = Sound_card::filter($filter)->get();
        return response()->json(["sound_cards"=>$sound_cards]);
    }
    public function get_wifi_cards(WifiCardFilter $filter)
    {
        $wifi_cards = Wifi_card::filter($filter)->get();
        return response()->json(["wifi_cards"=>$wifi_cards]);
    }

    public function get_wired_network_cards(WiredNetworkCardFilter $filter)
    {
        $wired_network_cards = Wired_network_card::filter($filter)
            ->with(['manufacturer','color','interface.interface'])->get();
        return response()->json(["wired_network_cards"=>$wired_network_cards]);
    }
}
