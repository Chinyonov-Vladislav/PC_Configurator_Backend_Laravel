<?php

namespace App\Http\Controllers;

use App\Models\Bearing_type;
use App\Models\Chipset;
use App\Models\Color;
use App\Models\Compatibility_case_with_videocard;
use App\Models\Computer_case;
use App\Models\Computer_case_fan;
use App\Models\Computer_interface;
use App\Models\Computer_part;
use App\Models\Connector;
use App\Models\Cooling_type;
use App\Models\Core_family;
use App\Models\cpu;
use App\Models\cpu_cooler;
use App\Models\Drive_bay;
use App\Models\Efficiency_rating;
use App\Models\Expansion_slot;
use App\Models\Form_factor;
use App\Models\Frame_sync_type;
use App\Models\Frequencies_memory_with_type;
use App\Models\Graphical_card;
use App\Models\Graphical_card_external_power_type;
use App\Models\Graphical_card_memory_type;
use App\Models\Integrated_graphic;
use App\Models\Internal_storage_device;
use App\Models\Led;
use App\Models\m2_slot;
use App\Models\Manufacturer;
use App\Models\Microarchitecture;
use App\Models\Modular_power_supply_type;
use App\Models\Motherboard;
use App\Models\Operating_range;
use App\Models\Optical_drive;
use App\Models\Output_power_supply_type;
use App\Models\Packaging;
use App\Models\Port;
use App\Models\Power_supply;
use App\Models\Power_supply_connector;
use App\Models\Ram;
use App\Models\Ram_ecc_registered_type;
use App\Models\Ram_module;
use App\Models\Ram_timing;
use App\Models\Series;
use App\Models\Side_panel;
use App\Models\sli_crossfire_type;
use App\Models\Socket;
use App\Models\Sound_card;
use App\Models\Sound_card_bit_depth;
use App\Models\Sound_card_channel;
use App\Models\ssd_nand_flash_type;
use App\Models\Type_internal_storage_device;
use App\Models\Type_memory;
use App\Models\Wifi_card_antenna;
use App\Models\Wireless_networking_type;
use App\Traits\HelpersGetValuesParaneters;
use stdClass;

class ParametersController extends Controller
{
    use HelpersGetValuesParaneters;
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
        $manufacturers = $this->get_manufacturers("computer_case_fans");

        $airflow_parameters= $this->find_min_max_value_from_min_max_value_column(Computer_case_fan::class,
            "airflow_min","airflow_max","airflow");
        // -----------
        $noise_level_parameters= $this->find_min_max_value_from_min_max_value_column(Computer_case_fan::class,
            "noise_level_min","noise_level_max","noise_level");
        // -----------

        $rpm_parameters= $this->find_min_max_value_from_min_max_value_column(Computer_case_fan::class,
            "rpm_min","rpm_max","rpm");
        //------
        $pmw_parameters = $this->get_parameters_for_boolean_nullable_variable();
        //-----
        $size_parameters = $this->find_min_max_value_for_column(Computer_case_fan::class, "size_mm");
        //------
        $static_pressure_parameters = $this->find_min_max_value_for_column(Computer_case_fan::class, "static_pressure");
        //-----
        $quantity_in_pack_parameters = $this->find_min_max_value_for_column(Computer_case_fan::class, "quantity_in_pack");
        //-----
        $colors = $this->get_colors("computer_case_fans");
        //-----
        $connectors = Connector::query()->whereHas("computer_case_fans", function($query){
            $query->whereNotNull('connector_id');
        })->select(["id", "name"])->get();
        //-----
        $controllers = \App\Models\Controller::query()->whereHas("computer_case_fans", function ($query){
            $query->whereNotNull('controller_id');
        })->select(['id', 'name'])->get();
        //-----
        $leds = Led::query()->whereHas("computer_case_fans", function ($query){
            $query->whereNotNull('led_id');
        })->select(['id', 'name'])->get();
        //-----
        $bearing_types = Bearing_type::query()->whereHas("computer_case_fans", function ($query){
            $query->whereNotNull('bearing_type_id');
        })->select(['id', 'name'])->distinct()->get();
        //-----php
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
        $count_cases = Computer_case::query()->count();
        if ($count_cases == 0)
        {
            return response()->json(["message"=>"Корпуса отсутствуют!"]);
        }
        $name_part_pc = "Cases";
        $row_from_bd_part_pc = $this->get_computer_part_from_database($name_part_pc);
        if ($row_from_bd_part_pc == null)
        {
            return response()->json(['error'=>""], 404);
        }
        $manufacturers = $this->get_manufacturers("computer_cases");
        //----
        $volume_parameters = $this->find_min_max_value_for_column(Computer_case::class, "volume");
        //----
        $colors = $this->get_colors("computer_cases");
        //----
        $side_panels = Side_panel::query()->whereHas("computer_cases", function ($query){
            $query->whereNotNull('color_id');
        })->select(['id', 'name'])->get();
        //----
        $form_factors = Form_factor::query()->whereHas("computer_cases",function ($query){
            $query->whereNotNull("form_factor_id");
        })->select(["id", "name"])
            ->get();
        //----
        $compatibility_case_with_videocards = Compatibility_case_with_videocard::query()->leftJoin("compatibility_with_videocard_types",
            "compatibility_case_with_videocards.compatibility_with_videocard_type_id","=","compatibility_with_videocard_types.id")
            ->select("compatibility_case_with_videocards.compatibility_with_videocard_type_id",
                "compatibility_with_videocard_types.name",
                \DB::raw('MIN(maximum_length_videocard_in_mm) AS min_length'),
                \DB::raw('MAX(maximum_length_videocard_in_mm) AS max_length'))
            ->groupBy("compatibility_with_videocard_type_id", "compatibility_with_videocard_types.name")
            ->get();
        //-----
        $ports = Port::query()->whereHas("computer_cases")
            ->select(["id","name"])
            ->get();
        //-----
        $expansion_slots = Expansion_slot::query()
            ->join("computer_case_expansion_slots","expansion_slots.id","=","computer_case_expansion_slots.expansion_slot_id")
            ->select("expansion_slots.id","expansion_slots.name",
                \DB::raw('MIN(count) AS min_count_expansion_slot'),
                \DB::raw('MAX(count) AS max_count_expansion_slot'))
            ->groupBy("expansion_slots.id","expansion_slots.name")
            ->get();
        //-----
        $drive_bays = Drive_bay::query()->join("computer_case_drive_bays", "drive_bays.id","=","computer_case_drive_bays.drive_bay_id")
            ->select("drive_bays.id", "drive_bays.name",
                \DB::raw('MIN(count) AS min_count_drive_bay'),
                \DB::raw('MAX(count) AS max_count_drive_bay'))
            ->groupBy("drive_bays.id", "drive_bays.name")
            ->get();
        return response()->json(["manufacturers"=>$manufacturers,
            'volume_parameters'=>$volume_parameters,
            'colors'=>$colors,
            'side_panels'=>$side_panels,
            "form_factors"=>$form_factors,
            "compatibility_case_with_videocards"=>$compatibility_case_with_videocards,
            "ports"=>$ports,
            "expansion_slots"=>$expansion_slots,
            'drive_bays'=>$drive_bays]);
    }
    public function get_parameters_cpu_coolers()
    {
        $name_part_pc = "CPU Coolers";
        $row_from_bd_part_pc = $this->get_computer_part_from_database($name_part_pc);
        if ($row_from_bd_part_pc == null)
        {
            return response()->json(['error'=>""], 404);
        }
        $manufacturers = $this->get_manufacturers("cpu_coolers");
        // -----
        $fanless_parameters = $this->get_parameters_for_boolean_nullable_variable();
        //-----

        $fan_rpm_parameters= $this->find_min_max_value_from_min_max_value_column(cpu_cooler::class,
            "fan_rpm_min","fan_rpm_max","fan_rpm");
        //-----
        $height_parameters= $this->find_min_max_value_for_column(cpu_cooler::class, "height_mm");
        //-----
        $noise_level_parameters = $this->find_min_max_value_from_min_max_value_column(cpu_cooler::class,
            "noise_level_min","noise_level_max","noise_level");
        //-----
        $radiator_size_parameters = $this->find_min_max_value_for_column(cpu_cooler::class, "radiator_size");
        //-----
        $water_cooled_parameters = $this->get_parameters_for_boolean_nullable_variable();
        //----
        $colors = $this->get_colors("cpu_coolers");
        //----
        $bearing_types = Bearing_type::query()->whereHas("cpu_coolers", function ($query){
            $query->whereNotNull("bearing_type_id");
        })->select(["id", "name"])->get();
        //----
        $sockets = Socket::query()->whereHas("cpu_coolers")
            ->select(["id", "name"])
            ->get();
        return response()->json(["manufacturers"=>$manufacturers,
            "fanless_parameters"=>$fanless_parameters,
            "fan_rpm_parameters"=>$fan_rpm_parameters,
            "height_parameters"=>$height_parameters,
            "noise_level_parameters" => $noise_level_parameters,
            "radiator_size_parameters"=>$radiator_size_parameters,
            "water_cooled_parameters"=>$water_cooled_parameters,
            "colors"=>$colors,
            "bearing_types"=>$bearing_types,
            "sockets"=>$sockets
        ]);
    }
    public function get_parameters_cpus()
    {
        $name_part_pc = "CPUs";
        $row_from_bd_part_pc = $this->get_computer_part_from_database($name_part_pc);
        if ($row_from_bd_part_pc == null)
        {
            return response()->json(['error'=>""], 404);
        }
        $manufacturers = $this->get_manufacturers("CPUs");
        //-----
        $performance_core_clock_ghz_parameters = $this->find_min_max_value_for_column(cpu::class, "performance_core_clock_ghz");
        //-----
        $core_count_parameters = $this->find_min_max_value_for_column(cpu::class, "core_count");
        //-----
        $performance_boost_clock_ghz_parameters = $this->find_min_max_value_for_column(cpu::class, "performance_boost_clock_ghz");
        //-----
        $tdp_w_parameters = $this->find_min_max_value_for_column(cpu::class, "tdp_w");
        //-----
        $includes_cooler_parameters = $this->get_parameters_for_boolean_nullable_variable();
        //------
        $ecc_support_parameters = $this->get_parameters_for_boolean_nullable_variable();
        //------
        $maximum_supported_memory_gb_parameters = $this->find_min_max_value_for_column(cpu::class, "maximum_supported_memory_gb");
        //---
        $l1_cache_performance_data_kbs_parameters = $this->find_min_max_value_for_column(cpu::class, "l1_cache_performance_data_kbs");
        //---
        $l1_cache_performance_instruction_kbs_parameters = $this->find_min_max_value_for_column(cpu::class, "l1_cache_performance_instruction_kbs");
        //---
        $l1_cache_efficiency_instruction_kbs_parameters = $this->find_min_max_value_for_column(cpu::class, "l1_cache_efficiency_instruction_kbs");
        //----
        $l1_cache_efficiency_data_kbs_parameters = $this->find_min_max_value_for_column(cpu::class,"l1_cache_efficiency_data_kbs");
        //----
        $l2_cache_performance_mbs_parameters = $this->find_min_max_value_for_column(cpu::class, "l2_cache_performance_mbs");
        //-----
        $l2_cache_efficiency_mbs_parameters = $this->find_min_max_value_for_column(cpu::class,"l2_cache_efficiency_mbs");
        //----
        $l3_cache_mbs_parameters = $this->find_min_max_value_for_column(cpu::class, "l3_cache_mbs");
        //----
        $lithography_nm_parameters = $this->find_min_max_value_for_column(cpu::class,"lithography_nm");
        //----
        $multithreading_parameters = $this->get_parameters_for_boolean_nullable_variable();
        //----
        $SMT_parameters = $this->get_parameters_for_boolean_nullable_variable();
        //----
        $includes_cpu_cooler_parameters = $this->get_parameters_for_boolean_nullable_variable();
        //----
        $core_family_parameters = Core_family::query()->whereHas("CPUs", function ($query){
            $query->whereNotNull("core_family_id");
        })->select(["id","name"])->get();
        //----
        $integrated_graphics_parameters = Integrated_graphic::query()->whereHas("CPUs", function ($query){
            $query->whereNotNull("integrated_graphic_id");
        })->select(["id","name"])->get();
        //----
        $microarchitectures_parameters = Microarchitecture::query()->whereHas("CPUs",function ($query)
        {
            $query->whereNotNull("integrated_graphic_id");
        })->select(["id","name"])->get();
        //----
        $packagings_parameters = Packaging::query()->whereHas("CPUs", function($query){
            $query->whereNotNull("packaging_id");
        })->select(["id","name"])->get();
        $series_parameters = Series::query()->whereHas("CPUs", function ($query){
            $query->whereNotNull("series_id");
        })->select(["id","name"])->get();
        $socket_parameters = Socket::query()->whereHas("CPUs", function ($query){
            $query->whereNotNull("socket_id");
        })->select(["id","name"])->get();
        //return response()->json(["l1_cache_performance_data_kbs_parameters"=>$l1_cache_performance_data_kbs_parameters]);
        return response()->json(["manufacturers"=>$manufacturers,
            "performance_core_clock_ghz_parameters"=>$performance_core_clock_ghz_parameters,
            "core_count_parameters"=>$core_count_parameters,
            "performance_boost_clock_ghz_parameters"=>$performance_boost_clock_ghz_parameters,
            "tdp_w_parameters"=>$tdp_w_parameters,
            'includes_cooler_parameters'=>$includes_cooler_parameters,
            "ecc_support_parameters"=>$ecc_support_parameters,
            "maximum_supported_memory_gb_parameters"=>$maximum_supported_memory_gb_parameters,
            "l1_cache_performance_data_kbs_parameters"=>$l1_cache_performance_data_kbs_parameters,
            "l1_cache_performance_instruction_kbs_parameters"=>$l1_cache_performance_instruction_kbs_parameters,
            "l1_cache_efficiency_instruction_kbs_parameters"=>$l1_cache_efficiency_instruction_kbs_parameters,
            "l1_cache_efficiency_data_kbs_parameters"=>$l1_cache_efficiency_data_kbs_parameters,
            "l2_cache_performance_mbs_parameters"=>$l2_cache_performance_mbs_parameters,
            "l2_cache_efficiency_mbs_parameters"=>$l2_cache_efficiency_mbs_parameters,
            "l3_cache_mbs_parameters"=>$l3_cache_mbs_parameters,
            "lithography_nm_parameters"=>$lithography_nm_parameters,
            "multithreading_parameters"=>$multithreading_parameters,
            "SMT_parameters"=>$SMT_parameters,
            "includes_cpu_cooler_parameters"=>$includes_cpu_cooler_parameters,
            "core_family_parameters"=>$core_family_parameters,
            "integrated_graphics_parameters"=>$integrated_graphics_parameters,
            "microarchitectures_parameters"=>$microarchitectures_parameters,
            "packagings_parameters"=>$packagings_parameters,
            "series_parameters"=>$series_parameters,
            "socket_parameters"=>$socket_parameters]);
    }
    public function get_parameters_graphic_cards()
    {
        $name_part_pc = "Graphics Cards";
        $row_from_bd_part_pc = $this->get_computer_part_from_database($name_part_pc);
        if ($row_from_bd_part_pc == null)
        {
            return response()->json(['error'=>""], 404);
        }
        $manufacturers = $this->get_manufacturers("graphical_cards");
        $count_memory_gb_parameters = $this->find_min_max_value_for_column(Graphical_card::class, "count_memory_gb");
        $clock_core_mhz_parameters = $this->find_min_max_value_for_column(Graphical_card::class, "clock_core_mhz");
        $boost_clock_mhz_parameters = $this->find_min_max_value_for_column(Graphical_card::class, "boost_clock_mhz");
        $length_mm_parameters = $this->find_min_max_value_for_column(Graphical_card::class, "length_mm");
        $TDP_w_parameters = $this->find_min_max_value_for_column(Graphical_card::class, "TDP_w");
        $total_slot_width_parameters = $this->find_min_max_value_for_column(Graphical_card::class, "total_slot_width");
        $case_expansion_slot_width_parameters = $this->find_min_max_value_for_column(Graphical_card::class, "case_expansion_slot_width");
        $effective_memory_clock_mhz_parameters = $this->find_min_max_value_for_column(Graphical_card::class, "effective_memory_clock_mhz");
        $chipset_parameters = Chipset::query()->whereHas("graphic_cards", function ($query){
            $query->whereNotNull("chipset_id");
        })->select(["id","name"])->get();
        $colors_parameters = $this->get_colors("graphical_cards");
        $cooling_type_parameters = Cooling_type::query()->whereHas("graphical_cards", function ($query){
            $query->whereNotNull("chipset_id");
        })->select(["id","name"])->get();
        $external_power_type_parameters = Graphical_card_external_power_type::query()->whereHas("graphical_cards", function ($query){
            $query->whereNotNull("external_power_type_id");
        })->select(["id","name"])->get();
        $memory_type_parameters = Graphical_card_memory_type::query()->whereHas("graphical_cards", function ($query){
            $query->whereNotNull("memory_type_id");
        })->select(["id","name"])->get();
        $frame_sync_type_parameters = Frame_sync_type::query()->whereHas("graphical_cards",function ($query){
            $query->whereNotNull("frame_sync_type_id");
        })->select(["id","name"])->get();
        $interface_parameters = Computer_interface::query()->whereHas("graphical_cards",function ($query){
            $query->whereNotNull("interface_id");
        })->select(["id","name"])->get();
        $sli_crossfire_type_parameters = sli_crossfire_type::query()->whereHas("graphical_cards")
            ->select(["id","name", "count_graphical_card"])->get();
        $ports_parameters = Port::query()->join("graphical_card_ports", "ports.id", "=","graphical_card_ports.port_id")
            ->select(["ports.id","ports.name",
                \DB::raw("MIN(count) as min_count"),
                \DB::raw("MAX(count) as max_count") ])
            ->groupBy("ports.id", "ports.name")
            ->get();
        return response()->json(["manufacturers"=>$manufacturers,
            "count_memory_gb_parameters"=>$count_memory_gb_parameters,
            "clock_core_mhz_parameters"=>$clock_core_mhz_parameters,
            "boost_clock_mhz_parameters"=>$boost_clock_mhz_parameters,
            "length_mm_parameters"=>$length_mm_parameters,
            "TDP_w_parameters"=>$TDP_w_parameters,
            "total_slot_width_parameters"=>$total_slot_width_parameters,
            "case_expansion_slot_width_parameters"=>$case_expansion_slot_width_parameters,
            "effective_memory_clock_mhz_parameters"=>$effective_memory_clock_mhz_parameters,
            "chipset_parameters"=>$chipset_parameters,
            "colors_parameters"=>$colors_parameters,
            "cooling_type_parameters"=>$cooling_type_parameters,
            "external_power_type_parameters"=>$external_power_type_parameters,
            "memory_type_parameters"=>$memory_type_parameters,
            "frame_sync_type_parameters"=>$frame_sync_type_parameters,
            "interface_parameters"=>$interface_parameters,
            "sli_crossfire_type_parameters"=>$sli_crossfire_type_parameters,
            "ports_parameters"=>$ports_parameters]);
    }
    public function get_parameters_storage_devices()
    {
        $name_part_pc = "Internal SSDs and Hard Drives";
        $row_from_bd_part_pc = $this->get_computer_part_from_database($name_part_pc);
        if ($row_from_bd_part_pc == null)
        {
            return response()->json(['error'=>""], 404);
        }
        $manufacturers = $this->get_manufacturers("internal_storage_devices");
        $cache_mb_parameters = $this->find_min_max_value_for_column(Internal_storage_device::class, "cache_mb");
        $capacity_gb_parameters = $this->find_min_max_value_for_column(Internal_storage_device::class, "capacity_gb");
        $price_for_gb_parameters = $this->find_min_max_value_for_column(Internal_storage_device::class, "price_for_gb");
        $price_for_gb_parameters->min = floatval($price_for_gb_parameters->min);
        $price_for_gb_parameters->max = floatval($price_for_gb_parameters->max);
        $nvme_parameters = $this->get_parameters_for_boolean_nullable_variable();
        $full_disk_write_throughput_mb_s_parameters = $this->find_min_max_value_for_column(Internal_storage_device::class, "full_disk_write_throughput_mb_s");
        $full_disk_write_throughput_last_10_seconds_mb_s_parameters = $this->find_min_max_value_for_column(Internal_storage_device::class, "full_disk_write_throughput_last_10_seconds_mb_s");
        $random_read_throughput_disk_50_full_parameters = $this->find_min_max_value_for_column(Internal_storage_device::class, "random_read_throughput_disk_50_full");
        $random_write_throughput_disk_50_full_parameters = $this->find_min_max_value_for_column(Internal_storage_device::class, "random_write_throughput_disk_50_full");
        $sequential_read_throughput_disk_50_full_parameters = $this->find_min_max_value_for_column(Internal_storage_device::class, "sequential_read_throughput_disk_50_full");
        $sequential_write_throughput_disk_50_full_parameters = $this->find_min_max_value_for_column(Internal_storage_device::class, "sequential_write_throughput_disk_50_full");
        $power_loss_protection_parameters = $this->get_parameters_for_boolean_nullable_variable();
        $hybrid_ssd_cache_mb_parameters = $this->find_min_max_value_for_column(Internal_storage_device::class, "hybrid_ssd_cache_mb");
        $rpm_parameters = $this->find_min_max_value_for_column(Internal_storage_device::class, "rpm");
        $form_factors_parameters = Form_factor::query()->whereHas("storage_devices", function ($query){
            $query->whereNotNull("form_factor_id");
        })->select(["id", "name"])->get();
        $interfaces_parameters = Computer_interface::query()->whereHas("storage_devices", function ($query){
            $query->whereNotNull("interface_id");
        })->select(["id", "name"])->get();
        $ssd_controllers = \App\Models\Controller::query()->whereHas("storage_devices", function ($query){
            $query->whereNotNull("ssd_controller_id");
        })->select(["id", "name"])->get();
        $types_internal_storage_devices = Type_internal_storage_device::query()->whereHas("internal_storage_devices", function ($query){
            $query->whereNotNull("type_internal_storage_device_id");
        })->select(["id", "name"])->get();
        $ssd_nand_flash_types = ssd_nand_flash_type::query()->whereHas("internal_storage_devices", function ($query){
            $query->whereNotNull("ssd_nand_flash_type_id");
        })->select(["id", "name"])->get();
        return response()->json(["manufacturers"=>$manufacturers,
            "cache_mb_parameters"=>$cache_mb_parameters,
            "capacity_gb_parameters"=>$capacity_gb_parameters,
            "price_for_gb_parameters"=>$price_for_gb_parameters,
            "nvme_parameters"=>$nvme_parameters,
            "full_disk_write_throughput_mb_s_parameters"=>$full_disk_write_throughput_mb_s_parameters,
            "full_disk_write_throughput_last_10_seconds_mb_s_parameters"=>$full_disk_write_throughput_last_10_seconds_mb_s_parameters,
            "random_read_throughput_disk_50_full_parameters"=>$random_read_throughput_disk_50_full_parameters,
            "random_write_throughput_disk_50_full_parameters"=>$random_write_throughput_disk_50_full_parameters,
            "sequential_read_throughput_disk_50_full_parameters"=>$sequential_read_throughput_disk_50_full_parameters,
            "sequential_write_throughput_disk_50_full_parameters"=>$sequential_write_throughput_disk_50_full_parameters,
            "power_loss_protection_parameters"=>$power_loss_protection_parameters,
            "hybrid_ssd_cache_mb_parameters"=>$hybrid_ssd_cache_mb_parameters,
            "rpm_parameters"=>$rpm_parameters,
            "form_factors_parameters"=>$form_factors_parameters,
            "interfaces_parameters"=>$interfaces_parameters,
            "ssd_controllers"=>$ssd_controllers,
            "types_internal_storage_devices"=>$types_internal_storage_devices,
            "ssd_nand_flash_types"=>$ssd_nand_flash_types]);
    }
    public function get_parameters_motherboards()
    {
        $name_part_pc = "Motherboards";
        $row_from_bd_part_pc = $this->get_computer_part_from_database($name_part_pc);
        if ($row_from_bd_part_pc == null)
        {
            return response()->json(['error'=>""], 404);
        }
        $manufacturers = $this->get_manufacturers("motherboards");
        $count_socket_parameters = $this->find_min_max_value_for_column(Motherboard::class, "count_sockets");
        $count_memory_slots_parameters = $this->find_min_max_value_for_column(Motherboard::class,"count_memory_slots");
        $memory_max_gb_parameters = $this->find_min_max_value_for_column(Motherboard::class, "memory_max_gb");
        $onboard_video_parameters = $this->get_parameters_for_boolean_nullable_variable();
        $support_ecc_parameters = $this->get_parameters_for_boolean_nullable_variable();
        $raid_support_parameters = $this->get_parameters_for_boolean_nullable_variable();
        $chipset_parameters = Chipset::query()->whereHas("motherboards", function ($query){
            $query->whereNotNull("chipset_id");
        })->select(["id", "name"])->get();
        $form_factor_parameters = Form_factor::query()->whereHas("motherboards",function ($query){
            $query->whereNotNull("form_factor_id");
        })->select(["id", "name"])->get();
        $socket_parameters = Socket::query()->whereHas("motherboards", function ($query){
            $query->whereNotNull("socket_id");
        })->select(["id", "name"])->get();
        $wireless_networking_type_parameters = Wireless_networking_type::query()->whereHas("motherboards", function ($query){
            $query->whereNotNull("wireless_networking_type_id");
        })->select(["id", "name"])->get();
        $memory_type_parameters = Type_memory::query()->whereHas("motherboards", function($query){
            $query->whereNotNull("memory_type_id");
        })->select(["id", "name"])->get();
        $m2_slots_parameters = m2_slot::query()->join("motherboard_m2_slots","m2_slots.id","=","motherboard_m2_slots.m2_slot_id")
            ->select("m2_slots.id", "m2_slots.name")
            ->groupBy("m2_slots.id", "m2_slots.name")
            ->get();
        $supported_memory_parameters = Frequencies_memory_with_type::query()
            ->join("type_memories","frequencies_memory_with_types.type_memory_id","=","type_memories.id")
            ->join("supported_memory_by_motherboards","frequencies_memory_with_types.id","=","supported_memory_by_motherboards.frequency_memory_type_id")
            ->select(["frequencies_memory_with_types.id","type_memories.name","frequencies_memory_with_types.frequency_mhz"])
            ->groupBy("frequencies_memory_with_types.id","type_memories.name","frequencies_memory_with_types.frequency_mhz")
            ->get();
        $onboard_internet_motherboard_parameters = new stdClass();
        $onboard_internet_motherboard_parameters->variant1 = true;
        $onboard_internet_motherboard_parameters->variant2 = false;
        $port_parameters = Port::query()->join("motherboard_ports", "ports.id", "=","motherboard_ports.computer_port_id")
            ->select(["ports.id","ports.name",
                \DB::raw("MIN(count) as min_count"),
                \DB::raw("MAX(count) as max_count") ])
            ->groupBy("ports.id", "ports.name")
            ->get();
        $interface_parameters = Computer_interface::query()->join("motherboard_interfaces", "computer_interfaces.id", "=","motherboard_interfaces.interface_id")
            ->select(["computer_interfaces.id","computer_interfaces.name",
                \DB::raw("MIN(count) as min_count"),
                \DB::raw("MAX(count) as max_count") ])
            ->groupBy("computer_interfaces.id", "computer_interfaces.name")
            ->get();
        $sli_crossfire_parameters = sli_crossfire_type::query()->join("motherboard_sli_crossfire_types","sli_crossfire_types.id","=","motherboard_sli_crossfire_types.sli_crossfire_type_id")
            ->select(["sli_crossfire_types.id", "sli_crossfire_types.name"])
            ->get();
        return response()->json(["manufacturers"=>$manufacturers,
            "count_socket_parameters"=>$count_socket_parameters,
            "count_memory_slots_parameters"=>$count_memory_slots_parameters,
            "memory_max_gb_parameters"=>$memory_max_gb_parameters,
            "onboard_video_parameters"=>$onboard_video_parameters,
            "support_ecc_parameters"=>$support_ecc_parameters,
            "raid_support_parameters"=>$raid_support_parameters,
            "chipset_parameters"=>$chipset_parameters,
            "form_factor_parameters"=>$form_factor_parameters,
            "socket_parameters"=>$socket_parameters,
            "wireless_networking_type_parameters"=>$wireless_networking_type_parameters,
            "memory_type_parameters"=>$memory_type_parameters,
            "m2_slots_parameters"=>$m2_slots_parameters,
            "supported_memory_parameters"=>$supported_memory_parameters,
            "onboard_internet_motherboard_parameters"=>$onboard_internet_motherboard_parameters,
            "port_parameters"=>$port_parameters,
            "interface_parameters"=>$interface_parameters,
            "sli_crossfire_parameters"=>$sli_crossfire_parameters]);
        // посмотреть sli_crossfire
    }
    public function get_parameters_optical_drives()
    {
        $name_part_pc = "Optical Drives";
        $row_from_bd_part_pc = $this->get_computer_part_from_database($name_part_pc);
        if ($row_from_bd_part_pc == null)
        {
            return response()->json(['error'=>""], 404);
        }
        $manufacturers = $this->get_manufacturers("optical_drives");
        $buffer_cache_mb_parameters = $this->find_min_max_value_for_column(Optical_drive::class, "buffer_cache_mb");
        $bd_minus_rom_speed_parameters = $this->find_min_max_value_for_column(Optical_drive::class, "bd_minus_rom_speed");
        $dvd_minus_rom_speed_parameters = $this->find_min_max_value_for_column(Optical_drive::class, "dvd_minus_rom_speed");
        $cd_minus_rom_speed_parameters = $this->find_min_max_value_for_column(Optical_drive::class, "cd_minus_rom_speed");
        $bd_minus_r_Speed_parameters = $this->find_min_max_value_for_column(Optical_drive::class, "bd_minus_r_Speed");
        $bd_minus_r_dual_layer_speed_parameters = $this->find_min_max_value_for_column(Optical_drive::class, "bd_minus_r_dual_layer_speed");
        $bd_minus_re_speed_parameters = $this->find_min_max_value_for_column(Optical_drive::class, "bd_minus_re_speed");
        $bd_minus_re_dual_layer_speed_parameters = $this->find_min_max_value_for_column(Optical_drive::class, "bd_minus_re_dual_layer_speed");
        $dvd_plus_r_speed_parameters = $this->find_min_max_value_for_column(Optical_drive::class, "dvd_plus_r_speed");
        $dvd_plus_rw_speed_parameters = $this->find_min_max_value_for_column(Optical_drive::class, "dvd_plus_rw_speed");
        $dvd_plus_r_dual_layer_speed_parameters = $this->find_min_max_value_for_column(Optical_drive::class, "dvd_plus_r_dual_layer_speed");
        $dvd_minus_rw_speed_parameters = $this->find_min_max_value_for_column(Optical_drive::class, "dvd_minus_rw_speed");
        $dvd_minus_r_dual_layer_speed_parameters = $this->find_min_max_value_for_column(Optical_drive::class, "dvd_minus_r_dual_layer_speed");
        $dvd_minus_ram_speed_parameters = $this->find_min_max_value_for_column(Optical_drive::class, "dvd_minus_ram_speed");
        $cd_minus_r_speed_parameters = $this->find_min_max_value_for_column(Optical_drive::class, "cd_minus_r_speed");
        $cd_minus_rw_speed_parameters = $this->find_min_max_value_for_column(Optical_drive::class, "cd_minus_rw_speed");
        $dvd_minus_r_speed_parameters = $this->find_min_max_value_for_column(Optical_drive::class, "dvd_minus_r_speed");
        $color_parameters = $this->get_colors("optical_drives");
        $form_factor_parameters = Form_factor::query()->whereHas("optical_drives")
            ->select(["id", "name"])->get();
        $interface_parameters = Computer_interface::query()->whereHas("optical_drives")
            ->select(["id", "name"])->get();
        return response()->json(["manufacturers"=>$manufacturers,
            "buffer_cache_mb_parameters"=>$buffer_cache_mb_parameters,
            "bd_minus_rom_speed_parameters"=>$bd_minus_rom_speed_parameters,
            "dvd_minus_rom_speed_parameters"=>$dvd_minus_rom_speed_parameters,
            "cd_minus_rom_speed_parameters"=>$cd_minus_rom_speed_parameters,
            "bd_minus_r_Speed_parameters"=>$bd_minus_r_Speed_parameters,
            "bd_minus_r_dual_layer_speed_parameters"=>$bd_minus_r_dual_layer_speed_parameters,
            "bd_minus_re_speed_parameters"=>$bd_minus_re_speed_parameters,
            "bd_minus_re_dual_layer_speed_parameters"=>$bd_minus_re_dual_layer_speed_parameters,
            "dvd_plus_r_speed_parameters"=>$dvd_plus_r_speed_parameters,
            "dvd_plus_rw_speed_parameters"=>$dvd_plus_rw_speed_parameters,
            "dvd_plus_r_dual_layer_speed_parameters"=>$dvd_plus_r_dual_layer_speed_parameters,
            "dvd_minus_rw_speed_parameters"=>$dvd_minus_rw_speed_parameters,
            "dvd_minus_r_dual_layer_speed_parameters"=>$dvd_minus_r_dual_layer_speed_parameters,
            "dvd_minus_ram_speed_parameters"=>$dvd_minus_ram_speed_parameters,
            "cd_minus_r_speed_parameters"=>$cd_minus_r_speed_parameters,
            "cd_minus_rw_speed_parameters"=>$cd_minus_rw_speed_parameters,
            "dvd_minus_r_speed_parameters"=>$dvd_minus_r_speed_parameters,
            "color_parameters"=>$color_parameters,
            "form_factor_parameters"=>$form_factor_parameters,
            "interface_parameters"=>$interface_parameters]);
    }
    public function get_parameters_power_supplies()
    {
        $name_part_pc = "Power Supplies";
        $row_from_bd_part_pc = $this->get_computer_part_from_database($name_part_pc);
        if ($row_from_bd_part_pc == null)
        {
            return response()->json(['error'=>""], 404);
        }
        $manufacturers = $this->get_manufacturers("power_supplies");
        $wattage_w_parameters = $this->find_min_max_value_for_column(Power_supply::class,"wattage_w");
        $length_mm_parameters = $this->find_min_max_value_for_column(Power_supply::class, "length_mm");
        $efficiency_percent_parameters = $this->find_min_max_value_for_column(Power_supply::class, "efficiency_percent");
        $fanless_parameters =$this->get_parameters_for_boolean_nullable_variable();
        $color_parameters = $this->get_colors("power_supplies");
        $efficiency_ratings_parameters = Efficiency_rating::query()->whereHas("power_supplies")
            ->select(["id", "name"])->get();
        $modular_type_parameters = Modular_power_supply_type::query()->whereHas("power_supplies")
            ->select(["id", "name"])->get();
        $form_factor_parameters = Form_factor::query()->whereHas("power_supplies")
            ->select(["id", "name"])->get();
        $output_power_supply_parameters = Output_power_supply_type::query()
            ->join("power_supply_outputs","output_power_supply_types.id","=","power_supply_outputs.output_type_id")
            ->select(["output_power_supply_types.id", "output_power_supply_types.name"])
            ->groupBy("output_power_supply_types.id", "output_power_supply_types.name")->get();
        /*$connector_parameters = Connector::query()->whereHas("power_supplies")
            ->select(["id", "name"])->get();*/
        $connector_parameters = Power_supply_connector::query()->leftJoin("connectors",
            "power_supply_connectors.connector_id","=","connectors.id")
            ->select("connectors.id", "connectors.name",
                \DB::raw('MIN(power_supply_connectors.count) AS min'),
                \DB::raw('MAX(power_supply_connectors.count) AS max'))
            ->groupBy("connectors.id", "connectors.name")
            ->get();
        return response()->json(["manufacturers"=>$manufacturers,
            "wattage_w_parameters"=>$wattage_w_parameters,
            "length_mm_parameters"=>$length_mm_parameters,
            "efficiency_percent_parameters"=>$efficiency_percent_parameters,
            "fanless_parameters"=>$fanless_parameters,
            "color_parameters"=>$color_parameters,
            "efficiency_ratings_parameters"=>$efficiency_ratings_parameters,
            "modular_type_parameters"=>$modular_type_parameters,
            "form_factor_parameters"=>$form_factor_parameters,
            "output_power_supply_parameters"=>$output_power_supply_parameters,
            "connector_parameters"=>$connector_parameters]);
    }
    public function get_parameters_ram_memories()
    {
        $name_part_pc = "RAM Memories";
        $row_from_bd_part_pc = $this->get_computer_part_from_database($name_part_pc);
        if ($row_from_bd_part_pc == null)
        {
            return response()->json(['error'=>""], 404);
        }
        $manufacturers = $this->get_manufacturers("rams");
        $total_capacity_memory_parameters = $this->find_min_max_value_for_column(Ram::class, "total_capacity_memory");
        $cas_latency_parameters = $this->find_min_max_value_for_column(Ram::class, "cas_latency");
        $first_word_latency_parameters = $this->find_min_max_value_for_column(Ram::class, "first_word_latency");
        $heat_spreader_parameters = $this->get_parameters_for_boolean_nullable_variable();
        $voltage_parameters = $this->find_min_max_value_for_column(Ram::class, "voltage");
        $price_gb_parameters = $this->find_min_max_value_for_column(Ram::class, "price_gb");
        $color_parameters = $this->get_colors("rams");
        $form_factor_parameters = Form_factor::query()->whereHas("ram")
            ->select(["id", "name"])->get();
        $module_parameters = Ram_module::query()->whereHas("rams")
            ->select(["id","count","capacity_one_ram_mb"])->get();
        $timing_parameters = Ram_timing::query()->whereHas("rams")
            ->select(["id","name"])->get();
        $frequency_memory_with_type_parameters = Frequencies_memory_with_type::query()->whereHas("rams")
            ->join("type_memories", "frequencies_memory_with_types.type_memory_id","=","type_memories.id")
            ->select(["frequencies_memory_with_types.id", "type_memories.name" ,"frequencies_memory_with_types.frequency_mhz"])
            ->distinct()
            ->get();
        $ecc_registered_parameters = Ram_ecc_registered_type::query()->whereHas("rams")
            ->select(["id","name"])->get();
        return response()->json(["manufacturers"=>$manufacturers,
            "total_capacity_memory_parameters"=>$total_capacity_memory_parameters,
            "cas_latency_parameters"=>$cas_latency_parameters,
            "first_word_latency_parameters"=>$first_word_latency_parameters,
            "heat_spreader_parameters"=>$heat_spreader_parameters,
            "voltage_parameters"=>$voltage_parameters,
            "price_gb_parameters"=>$price_gb_parameters,
            "color_parameters"=>$color_parameters,
            "form_factor_parameters"=>$form_factor_parameters,
            "module_parameters"=>$module_parameters,
            "timing_parameters"=>$timing_parameters,
            "frequency_memory_with_type_parameters"=>$frequency_memory_with_type_parameters,
            "ecc_registered_parameters"=>$ecc_registered_parameters]);
    }
    public function get_parameters_sound_cards()
    {
        $name_part_pc = "Sound Cards";
        $row_from_bd_part_pc = $this->get_computer_part_from_database($name_part_pc);
        if ($row_from_bd_part_pc == null)
        {
            return response()->json(['error'=>""], 404);
        }
        $manufacturers = $this->get_manufacturers("sound_cards");
        $value_sample_rate_hz_parameters = $this->find_min_max_value_for_column(Sound_card::class, "value_sample_rate_hz");
        $signal_to_noise_ratio_parameters = $this->find_min_max_value_for_column(Sound_card::class, "signal_to_noise_ratio");
        $color_parameters = $this->get_colors("sound_cards");
        $chipset_parameters = Chipset::query()->whereHas("sound_cards")
            ->select(["id", "name"])->get();
        $channel_parameters = Sound_card_channel::query()->whereHas("sound_cards")
            ->select(["id", "name"])->get();
        $bit_depth_parameters = Sound_card_bit_depth::query()->whereHas("sound_cards")
            ->select(["id", "name"])->get();
        $interface_parameters = Computer_interface::query()->whereHas("sound_cards")
            ->select(["id", "name"])->get();
        return response()->json(["manufacturers"=>$manufacturers,
            "value_sample_rate_hz_parameters"=>$value_sample_rate_hz_parameters,
            "signal_to_noise_ratio_parameters"=>$signal_to_noise_ratio_parameters,
            "color_parameters"=>$color_parameters,
            "chipset_parameters"=>$chipset_parameters,
            "channel_parameters"=>$channel_parameters,
            "bit_depth_parameters"=>$bit_depth_parameters,
            "interface_parameters"=>$interface_parameters]);
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
        $interface_parameters = Computer_interface::query()->whereHas("wifi_cards")
            ->select(["id", "name"])->get();
        $protocol_parameters = Wireless_networking_type::query()->whereHas("wifi_cards")
            ->select(["id","name"])->get();
        $operating_range_parameters = Operating_range::query()->whereHas("wifi_cards")
            ->select(["id","name"])->get();
        $color_parameters = $this->get_colors("wifi_cards");
        $antenna_parameters = Wifi_card_antenna::query()->whereHas("wifi_cards")
            ->select(["id","name"])->get();
        return response()->json(["manufacturers"=>$manufacturers,
            "interface_parameters"=>$interface_parameters,
            "protocol_parameters"=>$protocol_parameters,
            "operating_range_parameters"=>$operating_range_parameters,
            "color_parameters"=>$color_parameters,
            "antenna_parameters"=>$antenna_parameters]);
    }
    public function get_parameters_wired_network_cards()
    {
        $name_part_pc = "Wired Network Cards";
        $row_from_bd_part_pc = $this->get_computer_part_from_database($name_part_pc);
        if ($row_from_bd_part_pc == null)
        {
            return response()->json(['error'=>__("messages.computer_part_not_found", ["name_computer_part" => $name_part_pc])], 404);
        }
        $manufacturers = $this->get_manufacturers("wired_network_cards");
        $colors = Color::query()->whereHas("wired_network_cards", function ($query){
            $query->whereNotNull('color_id');
        })->select(['id', 'name'])->get();

        $interfaces = Computer_interface::query()->whereHas("wired_network_cards")
            ->select(array("id","name"))
            ->get();
        return response()->json(["manufacturers"=>$manufacturers,
            "colors"=>$colors,
            "interfaces"=>$interfaces],200);
    }
}
