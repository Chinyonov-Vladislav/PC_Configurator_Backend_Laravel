<?php

namespace App\Http\Controllers;

use App\Models\Bearing_type;
use App\Models\Color;
use App\Models\Computer_case_fan;
use App\Models\Computer_interface;
use App\Models\Computer_part;
use App\Models\Computer_part_bearing_type;
use App\Models\Computer_part_connector;
use App\Models\Computer_part_controller;
use App\Models\Computer_part_interface;
use App\Models\Connector;
use App\Models\Led;
use App\Models\Manufacturer;
use stdClass;

class ParametersController extends Controller
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
    public function get_parameters_case_fans()
    {
        $count_case_fans = Computer_case_fan::query()->count();
        if ($count_case_fans == 0)
        {
            return response()->json(["message"=>"Кулеры корпуса отсутствуют!"]);
        }
        $name_part_pc = "Case Fans";
        $row_from_bd_part_pc = $this->get_computer_part_from_database($name_part_pc);
        if ($row_from_bd_part_pc == null)
        {
            return response()->json(['error'=>""], 404);
        }
        $id_pc_part = $row_from_bd_part_pc->id;
        $manufacturers = $this->get_manufacturers("computer_case_fans");
        // -----------
        $min_value_from_airflow_min = Computer_case_fan::query()->min("airflow_min");
        $min_value_from_airflow = Computer_case_fan::query()->min("airflow");

        $max_value_from_airflow_max = Computer_case_fan::query()->max("airflow_max");
        $max_value_from_airflow = Computer_case_fan::query()->max("airflow");

        $airflow_parameters= new stdClass();
        // возможно добавить проверка на то, что значения null
        $airflow_parameters->min = ($min_value_from_airflow_min === null ||
            ($min_value_from_airflow !== null && $min_value_from_airflow_min > $min_value_from_airflow))
            ? $min_value_from_airflow
            : $min_value_from_airflow_min;
        $airflow_parameters->max = ($max_value_from_airflow === null ||
            $max_value_from_airflow_max !==null && $max_value_from_airflow_max > $max_value_from_airflow)
            ? $max_value_from_airflow_max
            : $max_value_from_airflow;
        // -----------
        $min_value_from_noise_level_min = Computer_case_fan::query()->min("noise_level_min");
        $min_value_from_noise_level = Computer_case_fan::query()->min("noise_level");
        $max_value_from_noise_level_max = Computer_case_fan::query()->max("noise_level_max");
        $max_value_from_noise_level = Computer_case_fan::query()->max("noise_level");

        $noise_level_parameters= new stdClass();
        $noise_level_parameters->min = ($min_value_from_noise_level_min === null ||
            ($min_value_from_noise_level !== null && $min_value_from_noise_level_min > $min_value_from_noise_level))
            ? $min_value_from_noise_level
            : $min_value_from_noise_level_min;

        $noise_level_parameters->max = ($max_value_from_noise_level === null ||
            $max_value_from_noise_level_max !==null && $max_value_from_noise_level_max > $max_value_from_noise_level)
            ? $max_value_from_noise_level_max
            : $max_value_from_noise_level;
        // --------
        $min_value_from_rpm_min = Computer_case_fan::query()->min("rpm_min");
        $min_value_from_rpm = Computer_case_fan::query()->min("rpm");

        $max_value_from_rpm_max = Computer_case_fan::query()->max("rpm_max");
        $max_value_from_rpm = Computer_case_fan::query()->max("rpm");

        $rpm_parameters= new stdClass();
        $rpm_parameters->min = ($min_value_from_rpm_min === null ||
            ($min_value_from_rpm !== null && $min_value_from_rpm_min > $min_value_from_rpm))
            ? $min_value_from_rpm
            : $min_value_from_rpm_min;
        $rpm_parameters->max = ($max_value_from_rpm === null ||
            $max_value_from_rpm_max !==null && $max_value_from_rpm_max > $max_value_from_rpm)
            ? $max_value_from_rpm_max
            : $max_value_from_rpm;
        //------
        $pmw_parameters = new stdClass();
        $pmw_parameters->variant1 = true;
        $pmw_parameters->variant2 = false;
        $pmw_parameters->variant3 = null;
        //-----
        $size_parameters = new stdClass();
        $size_parameters->min = Computer_case_fan::query()->min("size_mm");
        $size_parameters->max = Computer_case_fan::query()->max("size_mm");
        //------
        $static_pressure_parameters = new stdClass();
        $static_pressure_parameters->min = Computer_case_fan::query()->min("static_pressure");
        $static_pressure_parameters->max = Computer_case_fan::query()->max("static_pressure");
        //-----
        $quantity_in_pack_parameters = new stdClass();
        $quantity_in_pack_parameters->min = Computer_case_fan::query()->min("quantity_in_pack");
        $quantity_in_pack_parameters->max = Computer_case_fan::query()->max("quantity_in_pack");
        //-----
        $colors = $this->get_colors("computer_case_fans");

        $connectors_id = Computer_part_connector::query()->where("computer_part_id", $id_pc_part)
            ->select("connector_id")->distinct()->get();
        $connectors = Connector::query()->whereIn("id", $connectors_id)->select(["id", "name"])->get();


        $controllers_id = Computer_part_controller::query()->where("computer_part_id", $id_pc_part)
            ->select("controller_id")->distinct()->get();
        $controllers = \App\Models\Controller::query()->whereIn("id",$controllers_id)
            ->select(["id", "name"])->get();

        $leds = Led::query()->whereHas("computer_case_fans", function ($query){
            $query->whereNotNull('led_id');
        })->select(['id', 'name'])->get();


        $bearing_types_id = Computer_part_bearing_type::query()->where("computer_part_id", $id_pc_part)
            ->select("bearing_type_id")->distinct()->get();
        $bearing_types = Bearing_type::query()->whereIn("id",$bearing_types_id)
            ->select(["id", "name"])->get();


        return response()->json(["airflow_parameters"=>$airflow_parameters,
            "noise_level_parameters"=>$noise_level_parameters,
            "rpm_parameters"=>$rpm_parameters,
            "pmw_parameters"=>$pmw_parameters,
            "size_parameters"=>$size_parameters,
            "static_pressure_parameters"=>$static_pressure_parameters,
            'quantity_in_pack_parameters'=>$quantity_in_pack_parameters,
            'manufacturers'=>$manufacturers,
            "colors"=>$colors,
            'connectors'=>$connectors,
            'controllers'=>$controllers,
            'leds'=>$leds,
            'bearing_types'=>$bearing_types]);

    }
    public function get_parameters_cases()
    {
        $name_part_pc = "Cases";
        $row_from_bd_part_pc = $this->get_computer_part_from_database($name_part_pc);
        if ($row_from_bd_part_pc == null)
        {
            return response()->json(['error'=>""], 404);
        }
        $id_pc_part = $row_from_bd_part_pc->id;
        $manufacturers = $this->get_manufacturers("computer_cases");
    }
    public function get_parameters_cpu_coolers()
    {
        $name_part_pc = "CPU Coolers";
        $row_from_bd_part_pc = $this->get_computer_part_from_database($name_part_pc);
        if ($row_from_bd_part_pc == null)
        {
            return response()->json(['error'=>""], 404);
        }
        $id_pc_part = $row_from_bd_part_pc->id;
        $manufacturers = $this->get_manufacturers("cpu_coolers");
    }
    public function get_parameters_cpus()
    {
        $name_part_pc = "CPUs";
        $row_from_bd_part_pc = $this->get_computer_part_from_database($name_part_pc);
        if ($row_from_bd_part_pc == null)
        {
            return response()->json(['error'=>""], 404);
        }
        $id_pc_part = $row_from_bd_part_pc->id;
        $manufacturers = $this->get_manufacturers("CPUs");
    }
    public function get_parameters_graphic_cards()
    {
        $name_part_pc = "Graphics Cards";
        $row_from_bd_part_pc = $this->get_computer_part_from_database($name_part_pc);
        if ($row_from_bd_part_pc == null)
        {
            return response()->json(['error'=>""], 404);
        }
        $id_pc_part = $row_from_bd_part_pc->id;
        $manufacturers = $this->get_manufacturers("graphical_cards");
    }
    public function get_parameters_storage_devices()
    {
        $name_part_pc = "Internal SSDs and Hard Drives";
        $row_from_bd_part_pc = $this->get_computer_part_from_database($name_part_pc);
        if ($row_from_bd_part_pc == null)
        {
            return response()->json(['error'=>""], 404);
        }
        $id_pc_part = $row_from_bd_part_pc->id;
        $manufacturers = $this->get_manufacturers("internal_storage_devices");
    }
    public function get_parameters_motherboards()
    {
        $name_part_pc = "Motherboards";
        $row_from_bd_part_pc = $this->get_computer_part_from_database($name_part_pc);
        if ($row_from_bd_part_pc == null)
        {
            return response()->json(['error'=>""], 404);
        }
        $id_pc_part = $row_from_bd_part_pc->id;
        $manufacturers = $this->get_manufacturers("motherboards");
    }
    public function get_parameters_optical_drives()
    {
        $name_part_pc = "Optical Drives";
        $row_from_bd_part_pc = $this->get_computer_part_from_database($name_part_pc);
        if ($row_from_bd_part_pc == null)
        {
            return response()->json(['error'=>""], 404);
        }
        $id_pc_part = $row_from_bd_part_pc->id;
        $manufacturers = $this->get_manufacturers("optical_drives");
    }
    public function get_parameters_power_supplies()
    {
        $name_part_pc = "Power Supplies";
        $row_from_bd_part_pc = $this->get_computer_part_from_database($name_part_pc);
        if ($row_from_bd_part_pc == null)
        {
            return response()->json(['error'=>""], 404);
        }
        $id_pc_part = $row_from_bd_part_pc->id;
        $manufacturers = $this->get_manufacturers("power_supplies");
    }
    public function get_parameters_ram_memories()
    {
        $name_part_pc = "RAM Memories";
        $row_from_bd_part_pc = $this->get_computer_part_from_database($name_part_pc);
        if ($row_from_bd_part_pc == null)
        {
            return response()->json(['error'=>""], 404);
        }
        $id_pc_part = $row_from_bd_part_pc->id;
        $manufacturers = $this->get_manufacturers("rams");
    }
    public function get_parameters_sound_cards()
    {
        $name_part_pc = "Sound Cards";
        $row_from_bd_part_pc = $this->get_computer_part_from_database($name_part_pc);
        if ($row_from_bd_part_pc == null)
        {
            return response()->json(['error'=>""], 404);
        }
        $id_pc_part = $row_from_bd_part_pc->id;
        $manufacturers = $this->get_manufacturers("sound_cards");
    }
    public function get_parameters_wifi_cards()
    {
        $name_part_pc = "WiFi Cards";
        $row_from_bd_part_pc = $this->get_computer_part_from_database($name_part_pc);
        if ($row_from_bd_part_pc == null)
        {
            return response()->json(['error'=>""], 404);
        }
        $id_pc_part = $row_from_bd_part_pc->id;
        $manufacturers = $this->get_manufacturers("wifi_cards");
    }
    public function get_parameters_wired_network_card()
    {
        $name_part_pc = "Wired Network Cards";
        $row_from_bd_part_pc = $this->get_computer_part_from_database($name_part_pc);
        if ($row_from_bd_part_pc == null)
        {
            return response()->json(['error'=>""], 404);
        }
        $id_pc_part = $row_from_bd_part_pc->id;
        $manufacturers = $this->get_manufacturers("wired_network_cards");
        $colors = Color::query()->whereHas("wired_network_cards", function ($query){
            $query->whereNotNull('color_id');
        })->select(['id', 'name'])->get();

        $interfaces_id = Computer_part_interface::query()->where("computer_part_id", $id_pc_part)
            ->select("computer_interface_id")
            ->distinct()
            ->get();

        $interfaces = Computer_interface::query()->whereIn("id", $interfaces_id)
            ->select(array("id","name"))
            ->get();

        return response()->json(["manufacturers"=>$manufacturers,
            "colors"=>$colors,
            "interfaces"=>$interfaces],200);
    }
}
