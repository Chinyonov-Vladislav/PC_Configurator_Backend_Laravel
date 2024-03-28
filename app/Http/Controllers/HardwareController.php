<?php

namespace App\Http\Controllers;

use App\Classes\ComputerPartsWithPagination;
use App\Classes\ComputerPartWithoutPagination;
use App\Classes\ErrorGetComputerParts;
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
use App\Http\Requests\RatingRequest;
use App\Http\Resources\ShortVersionComputerPart\ShortVersionCaseFanResource;
use App\Http\Resources\ShortVersionComputerPart\ShortVersionComputerCaseResource;
use App\Http\Resources\ShortVersionComputerPart\ShortVersionCpuCoolerResource;
use App\Http\Resources\ShortVersionComputerPart\ShortVersionCpuResource;
use App\Http\Resources\ShortVersionComputerPart\ShortVersionGraphicalCardResource;
use App\Http\Resources\ShortVersionComputerPart\ShortVersionMotherboardResource;
use App\Http\Resources\ShortVersionComputerPart\ShortVersionOpticalDriveResource;
use App\Http\Resources\ShortVersionComputerPart\ShortVersionPowerSupplyResource;
use App\Http\Resources\ShortVersionComputerPart\ShortVersionRamResource;
use App\Http\Resources\ShortVersionComputerPart\ShortVersionSoundCardResource;
use App\Http\Resources\ShortVersionComputerPart\ShortVersionStorageDeviceResource;
use App\Http\Resources\ShortVersionComputerPart\ShortVersionWifiCardResource;
use App\Http\Resources\ShortVersionComputerPart\ShortVersionWiredNetworkCardResource;
use App\Models\Computer_case;
use App\Models\Computer_case_fan;
use App\Models\Computer_part;
use App\Models\cpu;
use App\Models\cpu_cooler;
use App\Models\Graphical_card;
use App\Models\Internal_storage_device;
use App\Models\Motherboard;
use App\Models\Optical_drive;
use App\Models\Power_supply;
use App\Models\Ram;
use App\Models\Rating;
use App\Models\Sound_card;
use App\Models\Wifi_card;
use App\Models\Wired_network_card;
use Illuminate\Http\Request;
use stdClass;

class HardwareController extends Controller
{
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
    }

    private function prepareResponse($resultObject, $resource)
    {
        logger("Тип объекта = " . gettype($resultObject));
        if ($resultObject instanceof ErrorGetComputerParts) {
            logger($resultObject->getTextError());
            return response()->json(["error" => $resultObject->getTextError()]);
        }
        if ($resultObject instanceof ComputerPartsWithPagination) {
            return response()->json(["items" => $resource::collection($resultObject->getHardwareItems()),
                "count_computer_part_items" => $resultObject->getCountComputerPartItems(),
                "exist_more_items" => $resultObject->getExistMoreItems()]);
        } //if($resultObject instanceof ComputerPartWithoutPagination)
        else {
            return response()->json(["items" => $resource::collection($resultObject->getHardwareItems()),
                "count_computer_part_items" => $resultObject->getCountComputerPartItems()]);
        }
    }

    private function getResultQuery(Request $request, object $query, string $name_item_response): ComputerPartWithoutPagination|ErrorGetComputerParts|ComputerPartsWithPagination
    {
        $key_page = "page";
        $key_count_items_on_page = "count_items_on_page";
        if (!$request->input($key_page)) {
            $computer_part_items = $query->get();
            $count_computer_part_items = count($computer_part_items);
            //return response()->json([$name_item_response=>$computer_part_items, "count_computer_part_items"=>$count_computer_part_items]);
            //return [$name_item_response=>$computer_part_items, "count_computer_part_items"=>$count_computer_part_items];
            return new ComputerPartWithoutPagination($computer_part_items, $count_computer_part_items);
        } else {
            $number_page = filter_var($request->input($key_page), FILTER_VALIDATE_INT) ? intval($request->input($key_page)) : null;
            if ($number_page === null) {
                //return response()->json(["error"=>"Неверно значение ключа $key_page в параметрах запроса"]);
                //return ["error"=>"Неверно значение ключа $key_page в параметрах запроса"];
                return new ErrorGetComputerParts("Неверно значение ключа $key_page в параметрах запроса");
            }
            if ($number_page < 1) {
                //return response()->json(["error"=>"Номер страницы может принимать только целые значения больше нуля"]);
                //return ["error"=>"Номер страницы может принимать только целые значения больше нуля"];
                return new ErrorGetComputerParts("Номер страницы может принимать только целые значения больше нуля");
            }
            if (!$request->input($key_count_items_on_page)) {
                //return response()->json(["error"=>"Отсутствует ключ $key_count_items_on_page, который необходим для пагинации"]);
                //return ["error"=>"Отсутствует ключ $key_count_items_on_page, который необходим для пагинации"];
                return new ErrorGetComputerParts("Отсутствует ключ $key_count_items_on_page, который необходим для пагинации");
            }
            $allowed_values_count_items_on_per_page = [10, 25, 50, 100];
            $count_items_on_page = filter_var($request->input($key_count_items_on_page), FILTER_VALIDATE_INT) ? intval($request->input($key_count_items_on_page)) : null;
            if ($count_items_on_page === null) {
                //return response()->json(["error"=>"Неверно значение ключа $key_count_items_on_page в параметрах запроса"]);
                //return ["error"=>"Неверно значение ключа $key_count_items_on_page в параметрах запроса"];
                return new ErrorGetComputerParts("Неверно значение ключа $key_count_items_on_page в параметрах запроса");
            }
            if (!in_array($count_items_on_page, $allowed_values_count_items_on_per_page)) {
                //return response()->json(["error"=>"Значение ключа $key_count_items_on_page в параметре запроса может принимать только следующие значения: 10,25,50,100"]);
                //return ["error"=>"Значение ключа $key_count_items_on_page в параметре запроса может принимать только следующие значения: 10,25,50,100"];
                return new ErrorGetComputerParts("Значение ключа $key_count_items_on_page в параметре запроса может принимать только следующие значения: 10,25,50,100");
            }
            if ($number_page === 1) {
                $computer_part = Computer_part::query()
                    ->where('name', "=", $name_item_response)
                    ->select("id")->first();
                if (!$computer_part) {
                    return new ErrorGetComputerParts("Компьютерное комлектующее типа $name_item_response не найдено среди доступных");
                }
                /*$count_computer_part_items = Computer_parts_link::query()->where("computer_part_id", "=", $computer_part->id)
                    ->where("is_parsed", "=", true)
                    ->count();*/
                $count_computer_part_items = $query->count();
            } else {
                $count_computer_part_items = null;
            }
            $computer_part_items = $query->skip(($number_page - 1) * $count_items_on_page)->take($count_items_on_page)->get();
            $exist_more_items = $query->skip($number_page * $count_items_on_page)->take($count_items_on_page)->get()->count() > 0;
            //return response()->json([$name_item_response=>$computer_part_items, "count_computer_part_items"=>$count_computer_part_items, "exist_more_items"=>$exist_more_items]);
            //return [$name_item_response=>$computer_part_items, "count_computer_part_items"=>$count_computer_part_items, "exist_more_items"=>$exist_more_items];
            return new ComputerPartsWithPagination($computer_part_items, $count_computer_part_items, $exist_more_items);
        }
    }

    /*public function get_count_computer_part(Request $request, $name_computer_part)
    {
        $computer_part = Computer_part::query()
            ->whereRaw('LOWER(name) = ?', [strtolower($name_computer_part)])
            ->select("id")->first();
        if (!$computer_part)
        {
            return response()->json(["error"=>"Компьютерное комлектующее типа $name_computer_part не найдено среди доступных"]);
        }
        $count_computer_part = Computer_parts_link::query()->where("computer_part_id", "=", $computer_part->id)
            ->where("is_parsed", "=", true)
            ->count();
        return response()->json(["count"=>$count_computer_part]);
    }*/

    public function get_case_fans(Request $request, CaseFanFilter $filter)
    {
        $name_item_response = "Case Fans";
        $query = Computer_case_fan::addWithToQuery(Computer_case_fan::filter($filter));
        logger(gettype($query));
        logger("SQL - запрос получения кулеров корпуса");
        logger($query->toSql());
        $resultObject = $this->getResultQuery($request, $query, $name_item_response);
        return $this->prepareResponse($resultObject, ShortVersionCaseFanResource::class);
        //$count = $computer_case_fans->count();
    }

    public function get_cases(Request $request, CaseFilter $filter)
    {
        $name_item_response = "Cases";
        $query = Computer_case::addWithToQuery(Computer_case::filter($filter));
        logger("SQL - запрос получения корпусов");
        logger($query->toSql());
        $resultObject = $this->getResultQuery($request, $query, $name_item_response);
        return $this->prepareResponse($resultObject, ShortVersionComputerCaseResource::class);
    }

    public function get_cpu_coolers(Request $request, CpuCoolerFilter $filter)
    {
        $name_item_response = "CPU Coolers";
        $query = cpu_cooler::addWithToQuery(cpu_cooler::filter($filter));
        logger("SQL - запрос получения кулеров процессора");
        logger($query->toSql());
        $resultObject = $this->getResultQuery($request, $query, $name_item_response);
        return $this->prepareResponse($resultObject, ShortVersionCpuCoolerResource::class);
    }

    public function get_cpus(Request $request, CpuFilter $filter)
    {
        $name_item_response = "CPUs";
        $query = cpu::addWithToQuery(cpu::filter($filter));
        logger("SQL - запрос получения процессоров");
        logger($query->toSql());
        $resultObject = $this->getResultQuery($request, $query, $name_item_response);
        return $this->prepareResponse($resultObject, ShortVersionCpuResource::class);
    }

    public function get_graphic_cards(Request $request, GraphicCardFilter $filter)
    {
        $name_item_response = "Graphics Cards";
        $query = Graphical_card::addWithToQuery(Graphical_card::filter($filter));
        logger("SQL - запрос получения графических карт");
        logger($query->toSql());
        $resultObject = $this->getResultQuery($request, $query, $name_item_response);
        return $this->prepareResponse($resultObject, ShortVersionGraphicalCardResource::class);
    }

    public function get_storage_devices(Request $request, StorageDeviceFilter $filter)
    {
        $name_item_response = "Internal SSDs and Hard Drives";
        $query = Internal_storage_device::addWithToQuery(Internal_storage_device::filter($filter));
        logger("SQL - запрос получения устройств хранения данных");
        logger($query->toSql());
        $resultObject = $this->getResultQuery($request, $query, $name_item_response);
        return $this->prepareResponse($resultObject, ShortVersionStorageDeviceResource::class);
    }

    public function get_motherboards(Request $request, MotherboardFilter $filter)
    {
        $name_item_response = "Motherboards";
        $query = Motherboard::addWithToQuery(Motherboard::filter($filter));
        logger("SQL - запрос получения материнских плат");
        logger($query->toSql());
        $resultObject = $this->getResultQuery($request, $query, $name_item_response);
        return $this->prepareResponse($resultObject, ShortVersionMotherboardResource::class);
    }

    public function get_optical_drives(Request $request, OpticalDriveFilter $filter)
    {
        $name_item_response = "Optical Drives";
        $query = Optical_drive::addWithToQuery(Optical_drive::filter($filter));
        logger("SQL - запрос получения оптических приводов");
        logger($query->toSql());
        $resultObject = $this->getResultQuery($request, $query, $name_item_response);
        return $this->prepareResponse($resultObject, ShortVersionOpticalDriveResource::class);
    }

    public function get_power_supplies(Request $request, PowerSupplyFilter $filter)
    {
        $name_item_response = "Power Supplies";
        $query = Power_supply::addWithToQuery(Power_supply::filter($filter));
        logger("SQL - запрос получения блоков питания");
        logger($query->toSql());
        $resultObject = $this->getResultQuery($request, $query, $name_item_response);
        return $this->prepareResponse($resultObject, ShortVersionPowerSupplyResource::class);
    }

    public function get_ram_memories(Request $request, RamMemoryFilter $filter)
    {
        $name_item_response = "RAM Memories";
        $query = Ram::addWithToQuery(Ram::filter($filter));
        logger("SQL - запрос получения оперативной памяти");
        logger($query->toSql());
        $resultObject = $this->getResultQuery($request, $query, $name_item_response);
        return $this->prepareResponse($resultObject, ShortVersionRamResource::class);
    }

    public function get_sound_cards(Request $request, SoundCardFilter $filter)
    {
        $name_item_response = "Sound Cards";
        $query = Sound_card::addWithToQuery(Sound_card::filter($filter));
        logger("SQL - запрос получения звуковых карт");
        logger($query->toSql());
        $resultObject = $this->getResultQuery($request, $query, $name_item_response);
        return $this->prepareResponse($resultObject, ShortVersionSoundCardResource::class);
    }

    public function get_wifi_cards(Request $request, WifiCardFilter $filter)
    {
        $name_item_response = "WiFi Cards";
        $query = Wifi_card::addWithToQuery(Wifi_card::filter($filter));
        logger("SQL - запрос получения wifi - карт");
        logger($query->toSql());
        $resultObject = $this->getResultQuery($request, $query, $name_item_response);
        return $this->prepareResponse($resultObject, ShortVersionWifiCardResource::class);
    }

    public function get_wired_network_cards(Request $request, WiredNetworkCardFilter $filter)
    {
        $name_item_response = "Wired Network Cards";
        $query = Wired_network_card::addWithToQuery(Wired_network_card::filter($filter));
        logger("SQL - запрос получения сетевых карт");
        logger($query->toSql());
        $resultObject = $this->getResultQuery($request, $query, $name_item_response);
        //$hiddenColumns = ["manufacturer_id", "color_id", "interface_id"];
        return $this->prepareResponse($resultObject, ShortVersionWiredNetworkCardResource::class);
    }

    public function get_case_fan(Request $request, $id)
    {
        $exist_case_fan = $this->case_fan->checkExistById($id);
        if (!$exist_case_fan) {
            return response()->json(["type" => "item_not_found", "error" => __("messages.case_cooler_not_found", ["id" => $id])], 404);
        }
        $itemHardware = Computer_case_fan::find($id);
        $ratings = $this->getCountPositiveAndNegativeRatingsForItemHardware($itemHardware);
        $exist_rating_from_auth_user = $this->existRatingForComputerPartForCurrentAuthUser($itemHardware);
        return response()->json(["item" => $this->case_fan->getItemById($id), "ratings"=>$ratings, "exist_rating_from_auth_user"=>$exist_rating_from_auth_user]);
    }

    public function get_case(Request $request, $id)
    {
        $exist_case = $this->case->checkExistById($id);
        if (!$exist_case) {
            return response()->json(["type" => "item_not_found", "error" => __("messages.case_not_found", ["id" => $id])], 404);
        }
        $itemHardware = Computer_case::find($id);
        $ratings = $this->getCountPositiveAndNegativeRatingsForItemHardware($itemHardware);
        $exist_rating_from_auth_user = $this->existRatingForComputerPartForCurrentAuthUser($itemHardware);
        return response()->json(["item" => $this->case->getItemById($id), "ratings"=>$ratings, "exist_rating_from_auth_user"=>$exist_rating_from_auth_user]);
    }

    public function get_cpu_cooler(Request $request, $id)
    {
        $exist_cpu_cooler = $this->cpu_cooler->checkExistById($id);
        if (!$exist_cpu_cooler) {
            return response()->json(["type" => "item_not_found", "error" => __("messages.cpu_cooler_not_found", ["id" => $id])], 404);
        }
        $itemHardware = cpu_cooler::find($id);
        $ratings = $this->getCountPositiveAndNegativeRatingsForItemHardware($itemHardware);
        $exist_rating_from_auth_user = $this->existRatingForComputerPartForCurrentAuthUser($itemHardware);

        return response()->json(["item" => $this->cpu_cooler->getItemById($id), "ratings"=>$ratings, "exist_rating_from_auth_user"=>$exist_rating_from_auth_user]);
    }

    public function get_cpu(Request $request, $id)
    {
        $exist_cpu = cpu::query()->where('id', $id)->exists();
        if (!$exist_cpu) {
            return response()->json(["type" => "item_not_found", "error" => __("messages.cpu_not_found", ["id" => $id])], 404);
        }
        $itemHardware = cpu::find($id);
        $ratings = $this->getCountPositiveAndNegativeRatingsForItemHardware($itemHardware);
        $exist_rating_from_auth_user = $this->existRatingForComputerPartForCurrentAuthUser($itemHardware);
        return response()->json(["item" => $this->cpu->getItemById($id), "ratings"=>$ratings, "exist_rating_from_auth_user"=>$exist_rating_from_auth_user]);
    }

    public function get_graphic_card(Request $request, $id)
    {
        $exist_graphical_card = $this->graphic_card->checkExistById($id);
        if (!$exist_graphical_card) {
            return response()->json(["type" => "item_not_found", "error" => __("messages.graphical_card_not_found", ["id" => $id])], 404);
        }
        $itemHardware = Graphical_card::find($id);
        $ratings = $this->getCountPositiveAndNegativeRatingsForItemHardware($itemHardware);
        $exist_rating_from_auth_user = $this->existRatingForComputerPartForCurrentAuthUser($itemHardware);
        return response()->json(["item" => $this->graphic_card->getItemById($id), "ratings"=>$ratings, "exist_rating_from_auth_user"=>$exist_rating_from_auth_user]);
    }

    public function get_storage_device(Request $request, $id)
    {
        $exist_internal_storage_device = $this->storage_device->checkExistById($id);
        if (!$exist_internal_storage_device) {
            return response()->json(["type" => "item_not_found", "error" => __("messages.storage_device_not_found", ["id" => $id])], 404);
        }
        $itemHardware = Internal_storage_device::find($id);
        $ratings = $this->getCountPositiveAndNegativeRatingsForItemHardware($itemHardware);
        $exist_rating_from_auth_user = $this->existRatingForComputerPartForCurrentAuthUser($itemHardware);
        return response()->json(["item" => $this->storage_device->getItemById($id), "ratings"=>$ratings, "exist_rating_from_auth_user"=>$exist_rating_from_auth_user]);
    }

    public function get_motherboard(Request $request, $id)
    {
        $exist_motherboard = $this->motherboard->checkExistById($id);
        if (!$exist_motherboard) {
            return response()->json(["type" => "item_not_found", "error" => __("messages.motherboard_not_found", ["id" => $id])], 404);
        }
        $itemHardware = Motherboard::find($id);
        $ratings = $this->getCountPositiveAndNegativeRatingsForItemHardware($itemHardware);
        $exist_rating_from_auth_user = $this->existRatingForComputerPartForCurrentAuthUser($itemHardware);
        return response()->json(["item" => $this->motherboard->getItemById($id), "ratings"=>$ratings, "exist_rating_from_auth_user"=>$exist_rating_from_auth_user]);
    }

    public function get_optical_drive(Request $request, $id)
    {
        $exist_optical_drive = $this->optical_drive->checkExistById($id);
        if (!$exist_optical_drive) {
            return response()->json(["type" => "item_not_found", "error" => __("messages.optical_drive_not_found", ["id" => $id])], 404);
        }
        $itemHardware = Optical_drive::find($id);
        $ratings = $this->getCountPositiveAndNegativeRatingsForItemHardware($itemHardware);
        $exist_rating_from_auth_user = $this->existRatingForComputerPartForCurrentAuthUser($itemHardware);
        return response()->json(["item" => $this->optical_drive->getItemById($id), "ratings"=>$ratings, "exist_rating_from_auth_user"=>$exist_rating_from_auth_user]);
    }

    public function get_power_supply(Request $request, $id)
    {
        $exist_power_supply = $this->power_supply->checkExistById($id);
        if (!$exist_power_supply) {
            return response()->json(["type" => "item_not_found", "error" => __("messages.power_supply_not_found", ["id" => $id])], 404);
        }
        $itemHardware = Power_supply::find($id);
        $ratings = $this->getCountPositiveAndNegativeRatingsForItemHardware($itemHardware);
        $exist_rating_from_auth_user = $this->existRatingForComputerPartForCurrentAuthUser($itemHardware);
        return response()->json(["item" => $this->power_supply->getItemById($id), "ratings"=>$ratings, "exist_rating_from_auth_user"=>$exist_rating_from_auth_user]);
    }

    public function get_ram_memory(Request $request, $id)
    {
        $exist_ram = $this->ram->checkExistById($id);
        if (!$exist_ram) {
            return response()->json(["type" => "item_not_found", "error" => __("messages.ram_not_found", ["id" => $id])], 404);
        }
        $itemHardware = Ram::find($id);
        $ratings = $this->getCountPositiveAndNegativeRatingsForItemHardware($itemHardware);
        $exist_rating_from_auth_user = $this->existRatingForComputerPartForCurrentAuthUser($itemHardware);
        return response()->json(["item" => $this->ram->getItemById($id), "ratings"=>$ratings, "exist_rating_from_auth_user"=>$exist_rating_from_auth_user]);
    }

    public function get_sound_card(Request $request, $id)
    {
        $exist_sound_card = $this->sound_card->checkExistById($id);
        if (!$exist_sound_card) {
            return response()->json(["type" => "item_not_found", "error" => __("messages.sound_card_not_found", ["id" => $id])], 404);
        }
        $itemHardware = Sound_card::find($id);
        $ratings = $this->getCountPositiveAndNegativeRatingsForItemHardware($itemHardware);
        $exist_rating_from_auth_user = $this->existRatingForComputerPartForCurrentAuthUser($itemHardware);
        return response()->json(["item" => $this->sound_card->getItemById($id), "ratings"=>$ratings, "exist_rating_from_auth_user"=>$exist_rating_from_auth_user]);
    }

    public function get_wifi_card(Request $request, $id)
    {
        $exist_wifi_card = $this->wifi_card->checkExistById($id);
        if (!$exist_wifi_card) {
            return response()->json(["type" => "item_not_found", "error" => __("messages.wifi_card_not_found", ["id" => $id])], 404);
        }
        $itemHardware = Wifi_card::find($id);
        $ratings = $this->getCountPositiveAndNegativeRatingsForItemHardware($itemHardware);
        $exist_rating_from_auth_user = $this->existRatingForComputerPartForCurrentAuthUser($itemHardware);
        return response()->json(["item" => $this->wifi_card->getItemById($id), "ratings"=>$ratings, "exist_rating_from_auth_user"=>$exist_rating_from_auth_user]);
    }

    public function get_wired_network_card(Request $request, $id)
    {
        $exist_wired_network_card = $this->wired_network_card->checkExistById($id);
        if (!$exist_wired_network_card) {
            return response()->json(["type" => "item_not_found", "error" => __("messages.wired_network_card_not_found", ["id" => $id])], 404);
        }
        $itemHardware = Wired_network_card::find($id);
        $ratings = $this->getCountPositiveAndNegativeRatingsForItemHardware($itemHardware);
        $exist_rating_from_auth_user = $this->existRatingForComputerPartForCurrentAuthUser($itemHardware);
        return response()->json(["item" => $this->wired_network_card->getItemById($id), "ratings"=>$ratings, "exist_rating_from_auth_user"=>$exist_rating_from_auth_user]);
    }

    public function add_delete_rating(RatingRequest $request)
    {
        $auth_user_id = auth()->id();
        if ($request->typeComputerPart == 1) //cpu
        {
            if (!$this->cpu->checkExistById($request->idComputerPart)) {
                return response()->json(["type" => "item_not_found", "error" => __("messages.cpu_not_found", ["id" => $request->idComputerPart])], 404);
            }
            $item_hardware = cpu::query()->find($request->idComputerPart);
            return $this->makeChangeInRating($item_hardware, $auth_user_id, $request->rating);
        }
        else if ($request->typeComputerPart == 2) //motherboard
        {
            if (!$this->motherboard->checkExistById($request->idComputerPart)) {
                return response()->json(["type" => "item_not_found", "error" => __("messages.motherboard_not_found", ["id" => $request->idComputerPart])], 404);
            }
            $item_hardware = Motherboard::query()->find($request->idComputerPart);
            return $this->makeChangeInRating($item_hardware, $auth_user_id, $request->rating);
        } else if ($request->typeComputerPart == 3) //cpu_cooler
        {
            if (!$this->cpu_cooler->checkExistById($request->idComputerPart)) {
                return response()->json(["type" => "item_not_found", "error" => __("messages.cpu_cooler_not_found", ["id" => $request->idComputerPart])], 404);
            }
            $item_hardware = cpu_cooler::query()->find($request->idComputerPart);
            return $this->makeChangeInRating($item_hardware, $auth_user_id, $request->rating);
        } else if ($request->typeComputerPart == 4) // ram
        {
            if (!$this->ram->checkExistById($request->idComputerPart)) {
                return response()->json(["type" => "item_not_found", "error" => __("messages.ram_not_found", ["id" => $request->idComputerPart])], 404);
            }
            $item_hardware = Ram::query()->find($request->idComputerPart);
            return $this->makeChangeInRating($item_hardware, $auth_user_id, $request->rating);
        } else if ($request->typeComputerPart == 5) // storage device
        {
            if (!$this->storage_device->checkExistById($request->idComputerPart)) {
                return response()->json(["type" => "item_not_found", "error" => __("messages.storage_device_not_found", ["id" => $request->idComputerPart])], 404);
            }
            $item_hardware = Internal_storage_device::query()->find($request->idComputerPart);
            return $this->makeChangeInRating($item_hardware, $auth_user_id, $request->rating);
        } else if ($request->typeComputerPart == 6) //graphical card
        {
            if (!$this->graphic_card->checkExistById($request->idComputerPart)) {
                return response()->json(["type" => "item_not_found", "error" => __("messages.graphical_card_not_found", ["id" => $request->idComputerPart])], 404);
            }
            $item_hardware = Graphical_card::query()->find($request->idComputerPart);
            return $this->makeChangeInRating($item_hardware, $auth_user_id, $request->rating);
        } else if ($request->typeComputerPart == 7) // power supply
        {
            if (!$this->power_supply->checkExistById($request->idComputerPart)) {
                return response()->json(["type" => "item_not_found", "error" => __("messages.power_supply_not_found", ["id" => $request->idComputerPart])], 404);
            }
            $item_hardware = Power_supply::query()->find($request->idComputerPart);
            return $this->makeChangeInRating($item_hardware, $auth_user_id, $request->rating);
        } else if ($request->typeComputerPart == 8) //case
        {
            if (!$this->case->checkExistById($request->idComputerPart)) {
                return response()->json(["type" => "item_not_found", "error" => __("messages.case_not_found", ["id" => $request->idComputerPart])], 404);
            }
            $item_hardware = Computer_case::query()->find($request->idComputerPart);
            return $this->makeChangeInRating($item_hardware, $auth_user_id, $request->rating);
        } else if ($request->typeComputerPart == 9) //case fan
        {
            if (!$this->case_fan->checkExistById($request->idComputerPart)) {
                return response()->json(["type" => "item_not_found", "error" => __("messages.case_cooler_not_found", ["id" => $request->idComputerPart])], 404);
            }
            $item_hardware = Computer_case_fan::query()->find($request->idComputerPart);
            return $this->makeChangeInRating($item_hardware, $auth_user_id, $request->rating);
        } else if ($request->typeComputerPart == 10) // optical drive
        {
            if (!$this->optical_drive->checkExistById($request->idComputerPart)) {
                return response()->json(["type" => "item_not_found", "error" => __("messages.optical_drive_not_found", ["id" => $request->idComputerPart])], 404);
            }
            $item_hardware = Optical_drive::query()->find($request->idComputerPart);
            return $this->makeChangeInRating($item_hardware, $auth_user_id, $request->rating);
        } else if ($request->typeComputerPart == 11) //sound card
        {
            if (!$this->sound_card->checkExistById($request->idComputerPart)) {
                return response()->json(["type" => "item_not_found", "error" => __("messages.sound_card_not_found", ["id" => $request->idComputerPart])], 404);
            }
            $item_hardware = Sound_card::query()->find($request->idComputerPart);
            return $this->makeChangeInRating($item_hardware, $auth_user_id, $request->rating);
        } else if ($request->typeComputerPart == 12) // wired network card
        {
            if (!$this->wired_network_card->checkExistById($request->idComputerPart)) {
                return response()->json(["type" => "item_not_found", "error" => __("messages.wired_network_card_not_found", ["id" => $request->idComputerPart])], 404);
            }
            $item_hardware = Wired_network_card::query()->find($request->idComputerPart);
            return $this->makeChangeInRating($item_hardware, $auth_user_id, $request->rating);
        } else // wifi card
        {
            if (!$this->wired_network_card->checkExistById($request->idComputerPart)) {
                return response()->json(["type" => "item_not_found", "error" => __("messages.wifi_card_not_found", ["id" => $request->idComputerPart])], 404);
            }
            $item_hardware = Wifi_card::query()->find($request->idComputerPart);
            return $this->makeChangeInRating($item_hardware, $auth_user_id, $request->rating);
        }
    }
    private function makeChangeInRating($itemHardware, $idAuthUser, $rating)
    {
        $rating_item_hardware_from_auth_user = Rating::query()
            ->where('ratingable_id', $itemHardware->id)
            ->where('ratingable_type', get_class($itemHardware))
            ->where("user_id", "=",$idAuthUser)
            ->first();
        if ($rating_item_hardware_from_auth_user === null) // еще не было
        {
            $new_rating = new Rating(["rating" => $rating, "user_id"=>$idAuthUser]);
            $itemHardware->ratings()->save($new_rating);
            $typeRating = $rating;
        }
        else {
            logger("Первый тип".gettype($rating_item_hardware_from_auth_user->rating));

            logger("Второй тип".gettype($rating));
            if ((boolean)$rating_item_hardware_from_auth_user->rating === $rating && $rating_item_hardware_from_auth_user->rating!==null) // удалить
            {
                $rating_item_hardware_from_auth_user->rating = null;
                $rating_item_hardware_from_auth_user->save();
                $typeRating = null;
            }
            else
            {
                $rating_item_hardware_from_auth_user->rating = $rating;
                $rating_item_hardware_from_auth_user->save();
                $typeRating = $rating;
            }
        }
        $ratings = $this->getCountPositiveAndNegativeRatingsForItemHardware($itemHardware);
        return response()->json(["ratings"=>$ratings, "typeRating"=>$typeRating]);
    }

    private function getCountPositiveAndNegativeRatingsForItemHardware($itemHardware)
    {
        /*return Rating::query()->selectRaw('
        COALESCE((SELECT COUNT(*) FROM ratings WHERE ratingable_id = ? AND ratingable_type = ? AND rating = 1), 0) as count_positive_ratings,
        COALESCE((SELECT COUNT(*) FROM ratings WHERE ratingable_id = ? AND ratingable_type = ? AND rating = 0), 0) as count_negative_ratings',
            [$itemHardware->id, get_class($itemHardware), $itemHardware->id, get_class($itemHardware)])
            ->first();*/
        $rating = Rating::query()
            ->selectRaw('COALESCE(SUM(rating = true),0) as count_positive_ratings, COALESCE(SUM(rating = false),0) as count_negative_ratings')
            ->where('ratingable_id', $itemHardware->id)
            ->where('ratingable_type', get_class($itemHardware))
            ->first();
        logger($rating);
        return $rating;
    }
    private function existRatingForComputerPartForCurrentAuthUser($itemHardware)
    {
        $auth_user_id = auth()->id();
        /*$existsPositiveRating = Rating::query()->where('user_id', $auth_user_id)
            ->where('ratingable_id', $itemHardware->id)
            ->where('ratingable_type', get_class($itemHardware))
            ->where('rating','=', true)
            ->exists();

        $existsNegativeRating = Rating::query()->where('user_id', $auth_user_id)
            ->where('ratingable_id', $itemHardware->id)
            ->where('ratingable_type', get_class($itemHardware))
            ->where('rating', '=', false)
            ->exists();*/

        $ratings = Rating::query()
            ->selectRaw('SUM(rating = true) as count_positive_ratings, SUM(rating = false) as count_negative_ratings')
            ->where('user_id', $auth_user_id)
            ->where('ratingable_id', $itemHardware->id)
            ->where('ratingable_type', get_class($itemHardware))
            ->first();

        $returnObject =new stdClass();
        $returnObject->exists_positive_rating = $ratings->count_positive_ratings > 0;
        $returnObject->exists_negative_rating = $ratings->count_negative_ratings > 0;

        return $returnObject;
    }
}
