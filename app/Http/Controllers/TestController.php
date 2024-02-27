<?php

namespace App\Http\Controllers;

use App\Http\Filters\MotherboardFilter;
use App\Http\Filters\WiredNetworkCardFilter;
use App\Models\Color;
use App\Models\Compatibility_case_with_videocard;
use App\Models\Computer_case;
use App\Models\Computer_case_fan;
use App\Models\Computer_interface;
use App\Models\Computer_part;
use App\Models\Computer_part_form_factor;
use App\Models\Computer_part_interface;
use App\Models\Form_factor;
use App\Models\Manufacturer;
use App\Models\Motherboard;
use App\Models\Side_panel;
use App\Models\Wired_network_card;
use Illuminate\Http\Request;
use stdClass;

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
    public function test_get_method(WiredNetworkCardFilter $filter)
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
        $id_pc_part = $row_from_bd_part_pc->id;
        $manufacturers = $this->get_manufacturers("computer_cases");
        //----
        $volume_parameters = new stdClass();
        $volume_parameters->min = Computer_case::query()->min("volume");
        $volume_parameters->max = Computer_case::query()->max("volume");
        //----
        $colors = $this->get_colors("computer_cases");
        $side_panels = Side_panel::query()->whereHas("computer_cases", function ($query){
            $query->whereNotNull('color_id');
        })->select(['id', 'name'])->get();
        $form_factors_id = Computer_part_form_factor::query()
            ->where("computer_part_id", $id_pc_part)
            ->select("form_factor_id")
            ->get();
        $form_factors = Form_factor::query()
            ->whereIn("id",$form_factors_id)
            ->select(["id", "name"])
            ->get();



        $compatibility_case_with_videocards = Compatibility_case_with_videocard::query()->select(
            "compatibility_with_videocard_type_id",
            \DB::raw('MIN(maximum_length_videocard_in_mm) AS min_length'),
            \DB::raw('MAX(maximum_length_videocard_in_mm) AS max_length'))
            ->with("compatibility_videocard_type")
            ->groupBy('compatibility_with_videocard_type_id')
            ->get();

        return response()->json(["values"=>$compatibility_case_with_videocards]);

        return response()->json(["manufacturers"=>$manufacturers,
            'volume_parameters'=>$volume_parameters,
            'colors'=>$colors,
            'side_panels'=>$side_panels,
            "form_factors"=>$form_factors]);
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
