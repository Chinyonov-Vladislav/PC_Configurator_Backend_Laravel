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
use App\Models\Color;
use App\Models\Computer_case;
use App\Models\Computer_part;
use App\Models\Manufacturer;
use Illuminate\Http\Request;
use stdClass;
use App\Http\Controllers\ParametersController;

class TestController extends Controller
{
    private function get_computer_part_from_database($name_part_pc)
    {
        return Computer_part::query()->where("name", $name_part_pc)
            ->select("id")
            ->first();
    }
    private function get_manufacturers($name_relation)
    {
        return Manufacturer::query()->whereHas($name_relation, function($query){
            $query->whereNotNull('manufacturer_id');
        })->select(['id', 'name'])->get();
    }
    private function get_colors($name_relation)
    {
        return Color::query()->whereHas($name_relation, function ($query){
            $query->whereNotNull('color_id');
        })->select(['id', 'name'])->get();
    }
    private function get_parameters_for_boolean_nullable_variable()
    {
        $parameters = new stdClass();
        $parameters->variant1 = true;
        $parameters->variant2 = false;
        $parameters->variant3 = null;
        return $parameters;
    }
    private function find_min_max_value_for_column(string $modelClassName, string $name_column)
    {
        $parameters = new stdClass();
        $parameters->min = $modelClassName::query()->min($name_column);
        $parameters->max = $modelClassName::query()->max($name_column);
        return $parameters;
    }
    public function test_get_method($typeComputerPart, $idComputerPart)
    {
        $name_chipset_motherboard = "AMD A55";
        //$motherboards = Motherboard::query()->with("socket")->get();
        //$motherboards = Motherboard::filter($filter)->get();
        /*$wired_network_cards = Wired_network_card::filter($filter)
            ->leftJoin("computer_part_interfaces","wired_network_cards.interface_id","computer_part_interfaces.id")
            ->join("computer_interfaces","computer_part_interfaces.computer_interface_id","computer_interfaces.id")
            ->select("wired_network_cards.*", "computer_interfaces.*")
            ->get();*/
        /*$wired_network_cards = Wired_network_card::filter($filter)
            ->with(['manufacturer','color','interface.interface'])->get();
        return response()->json(["wired_network_cards"=>$wired_network_cards],200);*/
        //$parameter_controller = new ParametersController();
        //$hardwareController = new HardwareController();
        $controller = new PDFController();
        /*return $hardwareController->get_case_fan($request, 1);
        return $hardwareController->get_case($request, 1);
        return $hardwareController->get_cpu_cooler($request, 1);
        return $hardwareController->get_cpu($request, 1);
        return $hardwareController->get_graphic_card($request, 1);
        return $hardwareController->get_storage_device($request, 1);
        return $hardwareController->get_motherboard($request, 1);
        return $hardwareController->get_optical_drive($request, 1);
        return $hardwareController->get_power_supply($request, 1);
        return $hardwareController->get_ram_memory($request, 1);
        return $hardwareController->get_sound_card($request, 1);
        return $hardwareController->get_wifi_card($request, 1);
        return $hardwareController->get_wired_network_card($request, 1);*/
        //return $parameter_controller->get_parameters_case_fans();
        //return $parameter_controller->get_parameters_cases();
        //return $parameter_controller->get_parameters_cpu_coolers();
        //return $parameter_controller->get_parameters_cpus();
        //return $parameter_controller->get_parameters_graphic_cards();
        //return $parameter_controller->get_parameters_storage_devices();
        //return $parameter_controller->get_parameters_motherboards();
        //return $parameter_controller->get_parameters_optical_drives();
        //return $parameter_controller->get_parameters_power_supplies();
        //return $parameter_controller->get_parameters_ram_memories();
        //return $parameter_controller->get_parameters_sound_cards();
        //return $parameter_controller->get_parameters_wifi_cards();
        //return $parameter_controller->get_parameters_wired_network_cards();
        //return $hardwareController->get_ram_memories($filter);
        //return $hardwareController->get_case($request, 2);
        //$pc_cases = Computer_case::with("compatibility_with_videocard_without_type")->get();
        //return response()->json(["cases"=>$pc_cases]);
        //return  $hardwareController->get_graphic_cards($request, $filter);
        //return $parameter_controller->get_parameters_ram_memories();
        //return $hardwareController->get_wired_network_cards($request, $filter);
        return $controller->generatePDF($typeComputerPart, $idComputerPart);
    }
    public function test_post_method(Request $request)
    {

    }
    public function test_put_method(Request $request)
    {

    }
    public function test_delete_method($id)
    {

    }
}
