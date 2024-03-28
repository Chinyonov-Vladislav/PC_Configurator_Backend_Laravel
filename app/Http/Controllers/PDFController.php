<?php

namespace App\Http\Controllers;

use App\Http\Resources\FullVersionComputerPart\FullVersionCaseFanResource;
use App\Http\Resources\FullVersionComputerPart\FullVersionComputerCaseResource;
use App\Http\Resources\FullVersionComputerPart\FullVersionCpuCoolerResource;
use App\Http\Resources\FullVersionComputerPart\FullVersionCpuResource;
use App\Http\Resources\FullVersionComputerPart\FullVersionGraphicalCardResource;
use App\Http\Resources\FullVersionComputerPart\FullVersionMotherboardResource;
use App\Http\Resources\FullVersionComputerPart\FullVersionOpticalDriveResource;
use App\Http\Resources\FullVersionComputerPart\FullVersionPowerSupplyResource;
use App\Http\Resources\FullVersionComputerPart\FullVersionRamResource;
use App\Http\Resources\FullVersionComputerPart\FullVersionSoundCardResource;
use App\Http\Resources\FullVersionComputerPart\FullVersionStorageDeviceResource;
use App\Http\Resources\FullVersionComputerPart\FullVersionWifiCardResource;
use App\Http\Resources\FullVersionComputerPart\FullVersionWiredNetworkCardResource;
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
use Barryvdh\DomPDF\Facade\Pdf;
use stdClass;
use function Termwind\renderUsing;

class PDFController extends Controller
{
    private stdClass $units;
    private Computer_case_fan $case_fan;
    private Computer_case $case;
    private cpu_cooler $cpu_cooler;
    private cpu $cpu;
    private Graphical_card $graphic_card;
    private Motherboard $motherboard;
    private Optical_drive $optical_drive;
    private Power_supply $power_supply;
    private Ram $ram;
    private Sound_card $sound_card;
    private Internal_storage_device $storage_device;
    private Wifi_card $wifi_card;
    private Wired_network_card $wired_network_card;

    public function __construct()
    {
        $this->case_fan = new Computer_case_fan();
        $this->case = new Computer_case();
        $this->cpu_cooler = new cpu_cooler();
        $this->cpu = new cpu();
        $this->graphic_card = new Graphical_card();
        $this->motherboard = new Motherboard();
        $this->optical_drive = new Optical_drive();
        $this->power_supply = new Power_supply();
        $this->ram = new Ram();
        $this->sound_card = new Sound_card();
        $this->storage_device = new Internal_storage_device();
        $this->wifi_card = new Wifi_card();
        $this->wired_network_card = new  Wired_network_card();
        $this->units = new StdClass();
        $this->units->mb = "mb";
        $this->units->gb = "gb";
        $this->units->volt = "V";
        $this->units->dB = "dB";
        $this->units->mbs = "mb/s";
        $this->units->kbs = "kb/s";
        $this->units->nm = "nm";
        $this->units->dollar = "$";
        $this->units->hz = "hz";
        $this->units->mhz = "mhz";
        $this->units->ghz = "ghz";
        $this->units->mm = "mm";
        $this->units->w = "w";
        $this->units->percent = "%";
        $this->units->x = "X";
        $this->units->l = "L";
        $this->units->static_pressure_unit = "mmH₂O";
    }

    public function generatePDF($typeComputerPart, $idComputerPart)
    {
        $existComputerPartById = Computer_case::query()->where("id", "=", $typeComputerPart)->exists();
        if (!$existComputerPartById) {
            return response()->json(["type" => "hardware_type_not_found", "error" => __("messages.hardware_type_not_found", ["id" => $typeComputerPart])], 404);
        }
        if ($typeComputerPart == 1) //cpu
        {
            $exist_cpu = $this->cpu->checkExistById($idComputerPart);
            if (!$exist_cpu) {
                return response()->json(["type" => "item_not_found", "error" => __("messages.cpu_not_found", ["id" => $idComputerPart])], 404);
            }
            $itemHardware = $this->cpu->getItemById($idComputerPart);
            $data = [
                'title' => 'Info about Hardware',
                'nameItemHardware' => $this->getFullNameItemHardware($itemHardware),
                'typeItemHardware' => __("messages.cpu"),
                'nameCharacteristicTitle' => __("messages.first_column_name"),
                "valueCharacteristicTitle" => __("messages.second_column_name"),
                "characteristics" => $this->getDataCharacteristicForCpu($itemHardware),
            ];
            $pdf = PDF::loadView('pdfItemHardware', $data);
            return $pdf->download('document.pdf');
        } else if ($typeComputerPart == 2)//motherboard
        {
            $exist_motherboard = $this->motherboard->checkExistById($idComputerPart);
            if (!$exist_motherboard) {
                return response()->json(["type" => "item_not_found", "error" => __("messages.motherboard_not_found", ["id" => $idComputerPart])], 404);
            }
            $itemHardware = $this->motherboard->getItemById($idComputerPart);
            $data = [
                'title' => 'Info about Hardware',
                'nameItemHardware' => $this->getFullNameItemHardware($itemHardware),
                'typeItemHardware' => __("messages.motherboard"),
                'nameCharacteristicTitle' => __("messages.first_column_name"),
                "valueCharacteristicTitle" => __("messages.second_column_name"),
                "characteristics" => $this->getDataCharacteristicForMotherboard($itemHardware),
            ];
            //return response()->json(["item"=>$itemHardware]);
        } else if ($typeComputerPart == 3)//cpu_cooler
        {
            $exist_cpu_cooler = $this->cpu_cooler->checkExistById($idComputerPart);
            if (!$exist_cpu_cooler) {
                return response()->json(["type" => "item_not_found", "error" => __("messages.cpu_cooler_not_found", ["id" => $idComputerPart])], 404);
            }
            $itemHardware = $this->cpu_cooler->getItemById($idComputerPart);
            $data = [
                'title' => 'Info about Hardware',
                'nameItemHardware' => $this->getFullNameItemHardware($itemHardware),
                'typeItemHardware' => __("messages.cpu_cooler"),
                'nameCharacteristicTitle' => __("messages.first_column_name"),
                "valueCharacteristicTitle" => __("messages.second_column_name"),
                "characteristics" => $this->getDataCharacteristicForCpuCooler($itemHardware),
            ];
        } else if ($typeComputerPart == 4)// ram
        {
            $exist_ram = $this->ram->checkExistById($idComputerPart);
            if (!$exist_ram) {
                return response()->json(["type" => "item_not_found", "error" => __("messages.ram_not_found", ["id" => $idComputerPart])], 404);
            }
            $itemHardware = $this->ram->getItemById($idComputerPart);
            $data = [
                'title' => 'Info about Hardware',
                'nameItemHardware' => $this->getFullNameItemHardware($itemHardware),
                'typeItemHardware' => __("messages.ram"),
                'nameCharacteristicTitle' => __("messages.first_column_name"),
                "valueCharacteristicTitle" => __("messages.second_column_name"),
                "characteristics" => $this->getDataCharacteristicForRAM($itemHardware),
            ];
            //return response(["item"=>$itemHardware]);

        } else if ($typeComputerPart == 5)// storage device
        {
            $exist_internal_storage_device = $this->storage_device->checkExistById($idComputerPart);
            if (!$exist_internal_storage_device) {
                return response()->json(["type" => "item_not_found", "error" => __("messages.storage_device_not_found", ["id" => $idComputerPart])], 404);
            }
            $itemHardware = $this->storage_device->getItemById($idComputerPart);
            $data = [
                'title' => 'Info about Hardware',
                'nameItemHardware' => $this->getFullNameItemHardware($itemHardware),
                'typeItemHardware' => __("messages.storage_device"),
                'nameCharacteristicTitle' => __("messages.first_column_name"),
                "valueCharacteristicTitle" => __("messages.second_column_name"),
                "characteristics" => $this->getDataCharacteristicForStorageDevice($itemHardware),
            ];
            //return response(["item"=>$itemHardware]);
        } else if ($typeComputerPart == 6)//graphical card
        {
            $exist_graphical_card = $this->graphic_card->checkExistById($idComputerPart);
            if (!$exist_graphical_card) {
                return response()->json(["type" => "item_not_found", "error" => __("messages.graphical_card_not_found", ["id" => $idComputerPart])], 404);
            }
            $itemHardware = $this->graphic_card->getItemById($idComputerPart);
            $data = [
                'title' => 'Info about Hardware',
                'nameItemHardware' => $this->getFullNameItemHardware($itemHardware),
                'typeItemHardware' => __("messages.graphical_card"),
                'nameCharacteristicTitle' => __("messages.first_column_name"),
                "valueCharacteristicTitle" => __("messages.second_column_name"),
                "characteristics" => $this->getDataCharacteristicForGraphicalCard($itemHardware),
            ];
            //return response(["item"=>$itemHardware]);
        } else if ($typeComputerPart == 7)// power supply
        {
            $exist_power_supply = $this->power_supply->checkExistById($idComputerPart);
            if (!$exist_power_supply) {
                return response()->json(["type" => "item_not_found", "error" => __("messages.power_supply_not_found", ["id" => $idComputerPart])], 404);
            }
            $itemHardware = $this->power_supply->getItemById($idComputerPart);
            $data = [
                'title' => 'Info about Hardware',
                'nameItemHardware' => $this->getFullNameItemHardware($itemHardware),
                'typeItemHardware' => __("messages.power_supply"),
                'nameCharacteristicTitle' => __("messages.first_column_name"),
                "valueCharacteristicTitle" => __("messages.second_column_name"),
                "characteristics" => $this->getDataCharacteristicForPowerSupply($itemHardware),
            ];
            //return response(["item"=>$itemHardware]);
        } else if ($typeComputerPart == 8)//case
        {
            $exist_case = $this->case->checkExistById($idComputerPart);
            if (!$exist_case) {
                return response()->json(["type" => "item_not_found", "error" => __("messages.case_not_found", ["id" => $idComputerPart])], 404);
            }
            $itemHardware = $this->case->getItemById($idComputerPart);
            $data = [
                'title' => 'Info about Hardware',
                'nameItemHardware' => $this->getFullNameItemHardware($itemHardware),
                'typeItemHardware' => __("messages.case"),
                'nameCharacteristicTitle' => __("messages.first_column_name"),
                "valueCharacteristicTitle" => __("messages.second_column_name"),
                "characteristics" => $this->getDataCharacteristicForCase($itemHardware),
            ];
            //return response(["item"=>$itemHardware]);
        } else if ($typeComputerPart == 9)//case fan
        {
            $exist_case_fan = $this->case_fan->checkExistById($idComputerPart);
            if (!$exist_case_fan) {
                return response()->json(["type" => "item_not_found", "error" => __("messages.case_cooler_not_found", ["id" => $idComputerPart])], 404);
            }
            $itemHardware = $this->case_fan->getItemById($idComputerPart);
            $data = [
                'title' => 'Info about Hardware',
                'nameItemHardware' => $this->getFullNameItemHardware($itemHardware),
                'typeItemHardware' => __("messages.case_fan"),
                'nameCharacteristicTitle' => __("messages.first_column_name"),
                "valueCharacteristicTitle" => __("messages.second_column_name"),
                "characteristics" => $this->getDataCharacteristicForCaseFan($itemHardware),
            ];
            //return response(["item"=>$itemHardware]);

        } else if ($typeComputerPart == 10)// optical drive
        {
            $exist_optical_drive = $this->optical_drive->checkExistById($idComputerPart);
            if (!$exist_optical_drive) {
                return response()->json(["type" => "item_not_found", "error" => __("messages.optical_drive_not_found", ["id" => $idComputerPart])], 404);
            }
            $itemHardware = $this->optical_drive->getItemById($idComputerPart);
            $data = [
                'title' => 'Info about Hardware',
                'nameItemHardware' => $this->getFullNameItemHardware($itemHardware),
                'typeItemHardware' => __("messages.optical_drive"),
                'nameCharacteristicTitle' => __("messages.first_column_name"),
                "valueCharacteristicTitle" => __("messages.second_column_name"),
                "characteristics" => $this->getDataCharacteristicForOpticalDrive($itemHardware),
            ];
            //return response(["item"=>$itemHardware]);
        } else if ($typeComputerPart == 11)//sound card
        {
            $exist_sound_card = $this->sound_card->checkExistById($idComputerPart);
            if (!$exist_sound_card) {
                return response()->json(["type" => "item_not_found", "error" => __("messages.sound_card_not_found", ["id" => $idComputerPart])], 404);
            }
            $itemHardware = $this->sound_card->getItemById($idComputerPart);
            $data = [
                'title' => 'Info about Hardware',
                'nameItemHardware' => $this->getFullNameItemHardware($itemHardware),
                'typeItemHardware' => __("messages.sound_card"),
                'nameCharacteristicTitle' => __("messages.first_column_name"),
                "valueCharacteristicTitle" => __("messages.second_column_name"),
                "characteristics" => $this->getDataCharacteristicForSoundCard($itemHardware),
            ];
            //return response(["item"=>$itemHardware]);
        } else if ($typeComputerPart == 12)// wired network card
        {
            $exist_wired_network_card = $this->wired_network_card->checkExistById($idComputerPart);
            if (!$exist_wired_network_card) {
                return response()->json(["type" => "item_not_found", "error" => __("messages.wired_network_card_not_found", ["id" => $idComputerPart])], 404);
            }
            $itemHardware = $this->wired_network_card->getItemById($idComputerPart);
            $data = [
                'title' => 'Info about Hardware',
                'nameItemHardware' => $this->getFullNameItemHardware($itemHardware),
                'typeItemHardware' => __("messages.wired_network_card"),
                'nameCharacteristicTitle' => __("messages.first_column_name"),
                "valueCharacteristicTitle" => __("messages.second_column_name"),
                "characteristics" => $this->getDataCharacteristicForWiredNetworkCard($itemHardware),
            ];
        } else// wifi card
        {
            $exist_wifi_card = $this->wifi_card->checkExistById($idComputerPart);
            if (!$exist_wifi_card) {
                return response()->json(["type" => "item_not_found", "error" => __("messages.wifi_card_not_found", ["id" => $idComputerPart])], 404);
            }
            $itemHardware = $this->wifi_card->getItemById($idComputerPart);
            $data = [
                'title' => 'Info about Hardware',
                'nameItemHardware' => $this->getFullNameItemHardware($itemHardware),
                'typeItemHardware' => __("messages.wifi_card"),
                'nameCharacteristicTitle' => __("messages.first_column_name"),
                "valueCharacteristicTitle" => __("messages.second_column_name"),
                "characteristics" => $this->getDataCharacteristicForWifiCard($itemHardware),
            ];
            //return response(["item"=>$itemHardware]);
        }
        return PDF::loadView('pdfItemHardware', $data)->setPaper('a4', 'landscape')->download();

    }

    private function convertBooleanToString(bool $value): string
    {
        if ($value) {
            return __("messages.yes");
        }
        return __("messages.no");
    }

    private function prepareValueCharacteristicMinMax($min, $max, $value): string|null
    {
        if ($value != null) {
            return (string)$value;
        } else if ($min != null && $max != null) {
            return $min . " - " . $max;
        }
        return null;
    }

    private function getNewCharacteristicObject(string $nameCharacteristic, string $valueCharacteristic): StdClass
    {
        $characteristic = new StdClass();
        $characteristic->name = $nameCharacteristic;
        $characteristic->value = $valueCharacteristic;
        return $characteristic;
    }

    private function getFullNameItemHardware($item): string
    {
        $arrayForFullName = array();
        if ($item->manufacturer != null) {
            $arrayForFullName[] = $item->manufacturer->name;
        }
        if ($item->model != null) {
            $arrayForFullName[] = $item->model;
        }
        return implode(' ', $arrayForFullName);
    }

    private function addCharacteristicIfValueNotNull(array &$characteristics, $nameCharacteristic, $valueCharacteristic, $unit = null)
    {
        if (!is_null($valueCharacteristic)) {
            if (is_bool($valueCharacteristic)) {
                $characteristics[] = $this->getNewCharacteristicObject($nameCharacteristic, $this->convertBooleanToString($valueCharacteristic));
                return;
            }
            if (is_object($valueCharacteristic)) {
                $characteristics[] = $this->getNewCharacteristicObject($nameCharacteristic, $valueCharacteristic->name);
                return;
            }
            if (is_null($unit)) {
                $characteristics[] = $this->getNewCharacteristicObject($nameCharacteristic, (string)$valueCharacteristic);
            }
            else
            {
                $characteristics[] = $this->getNewCharacteristicObject($nameCharacteristic, $valueCharacteristic ." ".$unit);
            }
        }
    }

    private function getDataCharacteristicForCpu(FullVersionCpuResource $item): array
    {
        $characteristics = [];
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.performance_core_clock"), $item->performance_core_clock_ghz, $this->units->ghz);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.core_count"), $item->core_count);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.performance_boost_clock"), $item->performance_boost_clock_ghz, $this->units->ghz);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.tdp"), $item->tdp_w, $this->units->w);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.includes_cooler"), $item->includes_cooler);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.ecc_support"), $item->ecc_support);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.maximum_supported_memory"), $item->maximum_supported_memory_gb, $this->units->gb);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.l1_cache_performance_data"), $item->l1_cache_performance_data_kbs, $this->units->kbs);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.l1_cache_performance_instruction"), $item->l1_cache_performance_instruction_kbs, $this->units->kbs);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.l1_cache_efficiency_instruction"), $item->l1_cache_efficiency_instruction_kbs, $this->units->kbs);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.l1_cache_efficiency_data"), $item->l1_cache_efficiency_data_kbs, $this->units->kbs);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.l2_cache_performance"), $item->l2_cache_performance_mbs, $this->units->mbs);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.l2_cache_efficiency"), $item->l2_cache_efficiency_mbs, $this->units->mbs);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.l3_cache"), $item->l3_cache_mbs, $this->units->mbs);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.lithography"), $item->lithography_nm, $this->units->nm);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.simultaneous_multithreading"), $item->multithreading);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.smt"), $item->SMT);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.includes_cpu_cooler"), $item->includes_cpu_cooler);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.model"), $item->model);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.manufacturer"), $item->manufacturer);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.core_family"), $item->core_family);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.integrated_graphics"), $item->integrated_graphic);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.microarchitecture"), $item->microarchitecture);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.packaging"), $item->packaging);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.series"), $item->series);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.socket"), $item->socket);
        return $characteristics;
    }

    private function getDataCharacteristicForMotherboard(FullVersionMotherboardResource $item): array
    {
        $characteristics = [];
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.model"), $item->model);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.count_sockets"), $item->count_sockets);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.memory_slots"), $item->count_memory_slots);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.memory_max"), $item->memory_max_gb, $this->units->gb);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.onboard_video"), $item->onboard_video);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.supports_ecc"), $item->support_ecc);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.raid_support"), $item->raid_support);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.chipset"), $item->chipset);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.form_factor"), $item->form_factor);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.manufacturer"), $item->manufacturer);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.socket"), $item->socket);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.wireless_networking"), $item->wireless_networking_type);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.memory_type"), $item->memory_type);
        if (count($item->m2_slots) > 0) {
            $array = array();
            foreach ($item->m2_slots as $slot) {
                $array[] = $slot->name;
            }
            $fullStrM2Slots = implode("\n", $array);
            $characteristics[] = $this->getNewCharacteristicObject(__("messages.m2_slots"), $fullStrM2Slots);
        }
        if (count($item->frequencies_memory_with_types) > 0) {
            $array = array();
            foreach ($item->frequencies_memory_with_types as $cycle_item) {
                $array[] = $cycle_item->type_memory->name . " - " . $cycle_item->frequency_mhz;
            }
            $fullStrCharacteristic = implode("\n", $array);
            $characteristics[] = $this->getNewCharacteristicObject(__("messages.memory_speed"), $fullStrCharacteristic);
        }
        if (count($item->onboard_internet_cards) > 0) {
            $array = array();
            foreach ($item->onboard_internet_cards as $cycle_item) {
                $item_array = $cycle_item->count;
                if ($cycle_item->manufacturer != null && $cycle_item->model != null) {
                    $item_array = $item_array . " X " . $cycle_item->manufacturer->name . " " . $cycle_item->model;
                } else if ($cycle_item->manufacturer == null && $cycle_item->model == null) {
                    $item_array = $item_array . " X " . __("messages.unknown");
                } else if ($cycle_item->manufacturer != null) {
                    $item_array = $item_array . " X " . $cycle_item->manufacturer->name;
                } else if ($cycle_item->model != null) {
                    $item_array = $item_array . " X " . $cycle_item->model;
                }
                $item_array = $item_array . " (" . $cycle_item->speed_gb_s . " Gb/s)";
                $array[] = $item_array;
            }
            $fullStrCharacteristic = implode("\n", $array);
            $characteristics[] = $this->getNewCharacteristicObject(__("messages.onboard_ethernet"), $fullStrCharacteristic);
        }
        if (count($item->ports) > 0) {
            $array = array();
            foreach ($item->ports as $cycle_item) {
                $array[] = $cycle_item->name;
            }
            $fullStrCharacteristic = implode("\n", $array);
            $characteristics[] = $this->getNewCharacteristicObject(__("messages.ports"), $fullStrCharacteristic);
        }
        if (count($item->computer_part_interfaces) > 0) {
            $array = array();
            foreach ($item->computer_part_interfaces as $cycle_item) {
                if ($cycle_item->count > 0) {
                    $array[] = $cycle_item->count . " X " . $cycle_item->name;
                }
            }
            if ($array > 0) {
                $fullStrCharacteristic = implode("\n", $array);
                $characteristics[] = $this->getNewCharacteristicObject(__("messages.interfaces"), $fullStrCharacteristic);
            }
        }
        if (count($item->sli_crossfire_types) > 0) {
            $array = array();
            foreach ($item->sli_crossfire_types as $cycle_item) {
                $array[] = $cycle_item->name;
            }
            $fullStrCharacteristic = implode("<br>", $array);
            $characteristics[] = $this->getNewCharacteristicObject(__("messages.sli/crossfire"), $fullStrCharacteristic);
        }
        return $characteristics;
    }

    private function getDataCharacteristicForCpuCooler(FullVersionCpuCoolerResource $item): array
    {
        $characteristics = [];
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.fanless"), $item->fanless);
        $fan_rpm = $this->prepareValueCharacteristicMinMax($item->fan_rpm_min, $item->fan_rpm_max, $item->fan_rpm);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.fan_rpm"), $fan_rpm);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.height"), $item->height_mm, $this->units->mm);
        $noise_level = $this->prepareValueCharacteristicMinMax($item->noise_level_min, $item->noise_level_max, $item->noise_level);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.noise_level"), $noise_level, $this->units->dB);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.radiator_size"), $item->radiator_size);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.water_cooled"), $item->water_cooled);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.model"), $item->model);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.color"), $item->color);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.manufacturer"), $item->manufacturer);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.bearing_type"), $item->bearing_type);
        if (count($item->sockets) > 0) {
            $array = array();
            foreach ($item->sockets as $socket) {
                $array[] = $socket->name;
            }
            $characteristics[] = $this->getNewCharacteristicObject(__("messages.sockets"), implode("\n", $array));
        }
        return $characteristics;
    }

    private function getDataCharacteristicForRAM(FullVersionRamResource $item): array
    {
        $characteristics = [];
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.model"), $item->model);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.total_capacity_memory"), $item->total_capacity_memory, $this->units->mb);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.cas_latency"), $item->cas_latency);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.first_word_latency"), $item->first_word_latency);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.heat_spreader"), $item->heat_spreader);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.voltage"), $item->voltage, $this->units->volt);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.price_gb"), $item->price_gb, $this->units->dollar);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.color"), $item->color);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.manufacturer"), $item->manufacturer);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.form_factor"), $item->form_factor);
        if ($item->module != null) {
            $characteristics[] = $this->getNewCharacteristicObject(__("messages.module"), $item->module->count . " X " . $item->module->capacity_one_ram_mb . " mb");
        }
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.timing"), $item->timing);

        if ($item->speed != null) {
            $characteristics[] = $this->getNewCharacteristicObject(__("messages.speed"), $item->speed->type_memory->name . " - " . $item->speed->frequency_mhz);
        }
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.ecc_registered"), $item->ecc_registered_type);
        return $characteristics;
    }

    private function getDataCharacteristicForStorageDevice(FullVersionStorageDeviceResource $item): array
    {
        $characteristics = [];
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.cache"), $item->cache_mb, $this->units->mb);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.capacity"), $item->capacity_gb, $this->units->gb);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.price_gb"), $item->price_for_gb, $this->units->dollar);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.nvme"), $item->nvme);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.full_disk_write_throughput"), $item->full_disk_write_throughput_mb_s, $this->units->mbs);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.full_disk_write_throughput_last_10_seconds"),
            $item->full_disk_write_throughput_last_10_seconds_mb_s, $this->units->mbs);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.random_read_throughput_disk_50_percent_full"),
            $item->random_read_throughput_disk_50_full);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.random_write_throughput_disk_50_percent_full"),
            $item->random_write_throughput_disk_50_full);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.sequential_read_throughput_disk_50_percent_full"),
            $item->sequential_read_throughput_disk_50_full);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.sequential_write_throughput_disk_50_percent_full"),
            $item->sequential_write_throughput_disk_50_full);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.model"), $item->model);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.power_loss_protection"), $item->power_loss_protection);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.hybrid_ssd_cache"), $item->hybrid_ssd_cache_mb,$this->units->mb);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.rpm"), $item->rpm);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.form_factor"), $item->form_factor);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.interface"), $item->interface);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.ssd_controller"), $item->ssd_controller);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.type"), $item->type_internal_storage_device);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.ssd_nand_flash_type"), $item->ssd_nand_flash_type);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.manufacturer"), $item->manufacturer);
        return $characteristics;
    }

    private function getDataCharacteristicForGraphicalCard(FullVersionGraphicalCardResource $item): array
    {
        $characteristics = [];
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.memory"), $item->count_memory_gb, $this->units->gb);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.core_clock"), $item->clock_core_mhz, $this->units->mhz);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.boost_clock"), $item->boost_clock_mhz, $this->units->mhz);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.length"), $item->length_mm, $this->units->mm);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.tdp"), $item->TDP_w, $this->units->w);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.total_slot_width"), $item->total_slot_width);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.case_expansion_slot_width"), $item->case_expansion_slot_width);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.effective_memory_clock"), $item->effective_memory_clock_mhz, $this->units->mhz);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.model"), $item->model);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.manufacturer"), $item->manufacturer);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.chipset"), $item->chipset);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.color"), $item->color);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.cooling"), $item->cooling_type);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.memory_type"), $item->memory_type);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.frame_sync"), $item->frame_sync_type);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.interface"), $item->interface);

        if (count($item->sli_crossfire_types) > 0) {
            $array = array();
            foreach ($item->sli_crossfire_types as $cycle_item) {
                $array[] = $item->sli_crossfire_types->name;
            }
            $characteristics[] = $this->getNewCharacteristicObject(__("messages.sli/crossfire"), implode("\n", $array));
        }
        if (count($item->ports) > 0) {
            $array = array();
            foreach ($item->ports as $port) {
                if ($port->count > 0) {
                    $array[] = $port->count . " X " . $port->name;
                }
            }
            if (count($array) > 0) {
                $characteristics[] = $this->getNewCharacteristicObject(__("messages.ports"), implode("\n", $array));
            }
        }
        return $characteristics;
    }

    private function getDataCharacteristicForPowerSupply(FullVersionPowerSupplyResource $item): array
    {
        $characteristics = [];
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.wattage"), $item->wattage_w, $this->units->w);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.length"), $item->length_mm, $this->units->mm);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.efficiency"), $item->efficiency_percent, $this->units->percent);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.fanless"), $item->fanless);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.model"), $item->model);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.color"), $item->color);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.manufacturer"), $item->manufacturer);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.efficiency_rating"), $item->efficiency_rating);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.modular"), $item->modular_type);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.form_factor"), $item->form_factor);
        if (count($item->outputs) > 0) {
            $array = array();
            foreach ($item->outputs as $output) {
                $array[] = $output->name;
            }
            $characteristics[] = $this->getNewCharacteristicObject(__("messages.outputs"), implode("\n", $array));
        }
        if (count($item->connectors) > 0) {
            $array = array();
            foreach ($item->connectors as $connector) {
                if ($connector->count > 0) {
                    $array[] = $connector->count . " X " . $connector->name;
                }
            }
            if (count($array) > 0) {
                $characteristics[] = $this->getNewCharacteristicObject(__("messages.connectors"), implode("\n", $array));
            }
        }
        return $characteristics;
    }

    private function getDataCharacteristicForCase(FullVersionComputerCaseResource $item): array
    {
        $characteristics = [];
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.model"), $item->model);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.volume"), $item->volume, $this->units->l);

        if ($item->dimension_length != null && $item->dimension_width != null && $item->dimension_height != null) {
            $characteristics[] = $this->getNewCharacteristicObject(__("messages.dimensions"), $item->dimension_length." ".$this->units->mm." X " . $item->dimension_width ." ".$this->units->mm." X " . $item->dimension_height." ".$this->units->mm);
        } else {
            $this->addCharacteristicIfValueNotNull($characteristics, __("messages.dimension_length"), $item->dimension_length, $this->units->mm);
            $this->addCharacteristicIfValueNotNull($characteristics, __("messages.dimension_width"), $item->dimension_width, $this->units->mm);
            $this->addCharacteristicIfValueNotNull($characteristics, __("messages.dimension_height"), $item->dimension_height, $this->units->mm);
        }
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.color"), $item->color);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.manufacturer"), $item->manufacturer);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.side_panel"), $item->side_panel);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.form_factor"), $item->form_factor);
        $array_compatibility_with_videocard = array();
        if (count($item->compatibility_with_videocard_types) > 0) {

            foreach ($item->compatibility_with_videocard_types as $cycle_item) {
                $array_compatibility_with_videocard[] = $cycle_item->name . ": " . $cycle_item->maximum_length_videocard_in_mm . " " . $this->units->mm;
            }
        }
        if ($item->compatibility_with_videocard_without_type != null) {
            $array_compatibility_with_videocard[] = $item->compatibility_with_videocard_without_type->maximum_length_videocard_in_mm . " " . $this->units->mm;
        }
        if (count($array_compatibility_with_videocard) > 0) {
            $characteristics[] = $this->getNewCharacteristicObject(__("messages.compatibility_with_graphical_card"), implode("\n", $array_compatibility_with_videocard));
        }
        if (count($item->ports) > 0) {
            $array = array();
            foreach ($item->ports as $port) {
                $array[] = $port->name;
            }
            $characteristics[] = $this->getNewCharacteristicObject(__("messages.ports"), implode("\n", $array));
        }
        if (count($item->drive_bays) > 0) {
            $array = array();
            foreach ($item->drive_bays as $drive_bay) {
                if ($drive_bay->count > 0) {
                    $array[] = $drive_bay->count . " X " . $drive_bay->name;
                }
            }
            if (count($array) > 0) {
                $characteristics[] = $this->getNewCharacteristicObject(__("messages.drive_bays"), implode("\n", $array));
            }
        }
        return $characteristics;
    }

    private function getDataCharacteristicForCaseFan(FullVersionCaseFanResource $item): array
    {
        $characteristics = [];
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.model"), $item->model);

        $airflow = $this->prepareValueCharacteristicMinMax($item->airflow_min, $item->airflow_max, $item->airflow);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.airflow"), $airflow);

        $noise_level = $this->prepareValueCharacteristicMinMax($item->noise_level_min, $item->noise_level_max, $item->noise_level);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.noise_level"), $noise_level);

        $rpm = $this->prepareValueCharacteristicMinMax($item->rpm_min, $item->rpm_max, $item->rpm);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.rpm"), $rpm);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.pwm"), $item->pmw);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.size"), $item->size_mm." ".$this->units->mm);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.static_pressure"), $item->static_pressure." ".$this->units->static_pressure_unit);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.quantity"), $item->quantity_in_pack);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.manufacturer"), $item->manufacturer);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.color"), $item->color);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.connector"), $item->connector);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.controller"), $item->controller);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.led"), $item->led);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.bearing_type"), $item->bearing_type);
        return $characteristics;
    }

    private function getDataCharacteristicForOpticalDrive(FullVersionOpticalDriveResource $item): array
    {
        $characteristics = [];
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.model"), $item->model);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.buffer_cache"), $item->buffer_cache_mb);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.bd-rom_speed"), $item->bd_minus_rom_speed, $this->units->x);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.dvd-rom_speed"), $item->dvd_minus_rom_speed, $this->units->x);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.cd-rom_speed"), $item->cd_minus_rom_speed, $this->units->x);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.bd-r_speed"), $item->bd_minus_r_Speed, $this->units->x);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.bd-r_dual-layer_speed"), $item->bd_minus_r_dual_layer_speed, $this->units->x);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.bd-re_speed"), $item->bd_minus_re_speed, $this->units->x);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.bd-re_dual-layer_speed"), $item->bd_minus_re_dual_layer_speed, $this->units->x);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.dvd+r_speed"), $item->dvd_plus_r_speed, $this->units->x);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.dvd+rw_speed"), $item->dvd_plus_rw_speed, $this->units->x);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.dvd+r_dual-layer_speed"), $item->dvd_plus_r_dual_layer_speed, $this->units->x);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.dvd-rw_speed"), $item->dvd_minus_rw_speed, $this->units->x);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.dvd-r_dual-layer_speed"), $item->dvd_minus_r_dual_layer_speed, $this->units->x);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.dvd-ram_speed"), $item->dvd_minus_ram_speed, $this->units->x);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.cd-r_speed"), $item->cd_minus_r_speed, $this->units->x);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.cd-rw_speed"), $item->cd_minus_rw_speed, $this->units->x);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.dvd-r_speed"), $item->dvd_minus_r_speed, $this->units->x);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.color"), $item->color);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.manufacturer"), $item->manufacturer);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.form_factor"), $item->form_factor);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.interface"), $item->interface);
        return $characteristics;
    }

    private function getDataCharacteristicForSoundCard(FullVersionSoundCardResource $item): array
    {
        $characteristics = [];
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.model"), $item->model);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.sample_rate"), $item->value_sample_rate_hz, $this->units->hz);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.signal_to_noise_ratio"), $item->signal_to_noise_ratio, $this->units->hz);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.color"), $item->color);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.chipset"), $item->chipset);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.channels"), $item->channel);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.interface"), $item->interface);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.digital_audio"), $item->sound_card_bit_depth);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.manufacturer"), $item->manufacturer);
        return $characteristics;
    }

    private function getDataCharacteristicForWifiCard(FullVersionWifiCardResource $item): array
    {
        $characteristics = [];
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.model"), $item->model);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.interface"), $item->interface);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.manufacturer"), $item->manufacturer);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.protocol"), $item->protocol);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.operating_range"), $item->operating_range);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.color"), $item->color);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.antenna"), $item->antenna);
        if (count($item->securities) > 0) {
            $array = array();
            foreach ($item->securities as $security) {
                $array[] = $security->name;
            }
            $characteristics[] = $this->getNewCharacteristicObject(__("messages.security"), implode("\n", $array));
        }
        return $characteristics;
    }

    private function getDataCharacteristicForWiredNetworkCard(FullVersionWiredNetworkCardResource $item): array
    {
        $characteristics = [];
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.model"), $item->model);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.manufacturer"), $item->manufacturer);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.color"), $item->color);
        $this->addCharacteristicIfValueNotNull($characteristics, __("messages.interface"), $item->interface);
        return $characteristics;
    }
}
