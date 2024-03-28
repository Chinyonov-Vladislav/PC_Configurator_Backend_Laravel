<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HardwareController;
use App\Http\Controllers\ParametersController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post('/signup', [AuthController::class, 'sign_up'])->name("sign_up");
Route::post('/login', [AuthController::class, 'login'])->name("login");
Route::post("/send_code_recover_password",[AuthController::class, "send_code_recover_password"])->name("send_code_recover_password");
Route::post("/check-valid-code",[AuthController::class, "checkValidCode"])->name("checkValidCode");
Route::post("/change-password",[AuthController::class, "changePassword"])->name("changePassword");
Route::group(['middleware' => ['auth:sanctum']], function () {
    //Route::get("/count_computer_part/{name_computer_part}", [HardwareController::class, "get_count_computer_part"])->name("get_count_computer_part");
    Route::get("/check-auth", [AuthController::class, "checkUserAuth"])->name("checkUserAuth");
    Route::get("/case_fans", [HardwareController::class, "get_case_fans"])->name("get_case_fans");
    Route::get("/cases", [HardwareController::class, "get_cases"])->name("get_cases");
    Route::get("/cpu_coolers", [HardwareController::class, "get_cpu_coolers"])->name("get_cpu_coolers");
    Route::get("/cpus", [HardwareController::class, "get_cpus"])->name("get_cpus");
    Route::get("/graphic_cards", [HardwareController::class, "get_graphic_cards"])->name("get_graphic_cards");
    Route::get("/storage_devices", [HardwareController::class, "get_storage_devices"])->name("get_storage_devices");
    Route::get("/motherboards", [HardwareController::class, "get_motherboards"])->name("get_motherboards");
    Route::get("/optical_drives", [HardwareController::class, "get_optical_drives"])->name("get_optical_drives");
    Route::get("/power_supplies", [HardwareController::class, "get_power_supplies"])->name("get_power_supplies");
    Route::get("/ram_memories", [HardwareController::class, "get_ram_memories"])->name("get_ram_memories");
    Route::get("/sound_cards", [HardwareController::class, "get_sound_cards"])->name("get_sound_cards");
    Route::get("/wifi_cards", [HardwareController::class, "get_wifi_cards"])->name("get_wifi_cards");
    Route::get("/wired_network_cards", [HardwareController::class, "get_wired_network_cards"])->name("get_wired_network_cards");

    Route::get("/case_fans_parameters",[ParametersController::class, "get_parameters_case_fans"])->name("get_parameters_case_fans");
    Route::get("/cases_parameters", [ParametersController::class, "get_parameters_cases"])->name("get_parameters_cases");
    Route::get("/cpu_coolers_parameters",[ParametersController::class, "get_parameters_cpu_coolers"])->name("get_parameters_cpu_coolers");
    Route::get("/cpus_parameters", [ParametersController::class, "get_parameters_cpus"])->name("get_parameters_cpus");
    Route::get("/graphic_cards_parameters", [ParametersController::class, "get_parameters_graphic_cards"])->name("get_parameters_graphic_cards");
    Route::get("/storage_devices_parameters", [ParametersController::class, "get_parameters_storage_devices"])->name("get_parameters_storage_devices");
    Route::get("/motherboards_parameters", [ParametersController::class, "get_parameters_motherboards"])->name("get_parameters_motherboards");
    Route::get("/optical_drives_parameters", [ParametersController::class, "get_parameters_optical_drives"])->name("get_parameters_optical_drives");
    Route::get("/power_supplies_parameters", [ParametersController::class, "get_parameters_power_supplies"])->name("get_parameters_power_supplies");
    Route::get("/ram_memories_parameters", [ParametersController::class, "get_parameters_ram_memories"])->name("get_parameters_ram_memories");
    Route::get("/sound_cards_parameters", [ParametersController::class, "get_parameters_sound_cards"])->name("get_parameters_sound_cards");
    Route::get("/wifi_cards_parameters", [ParametersController::class, "get_parameters_wifi_cards"])->name("get_parameters_wifi_cards");
    Route::get("/wired_network_cards_parameters", [ParametersController::class, "get_parameters_wired_network_cards"])->name("get_parameters_wired_network_cards");


    Route::get("/case_fan/{id}", [HardwareController::class, "get_case_fan"])
        ->where('id', '[0-9]+')->name("get_case_fan"); // выполнено
    Route::get("/case/{id}", [HardwareController::class, "get_case"])
        ->where('id', '[0-9]+')->name("get_case"); // выполнено
    Route::get("/cpu_cooler/{id}", [HardwareController::class, "get_cpu_cooler"])
        ->where('id', '[0-9]+')->name("get_cpu_cooler"); // выполнено
    Route::get("/cpu/{id}", [HardwareController::class, "get_cpu"])
        ->where('id', '[0-9]+')->name("get_cpu"); // выполнено
    Route::get("/graphic_card/{id}", [HardwareController::class, "get_graphic_card"])
        ->where('id', '[0-9]+')->name("get_graphic_card"); // выполнено
    Route::get("/storage_device/{id}", [HardwareController::class, "get_storage_device"])
        ->where('id', '[0-9]+')->name("get_storage_device"); // выполнено
    Route::get("/motherboard/{id}", [HardwareController::class, "get_motherboard"])
        ->where('id', '[0-9]+')->name("get_motherboard"); // выполнено
    Route::get("/optical_drive/{id}", [HardwareController::class, "get_optical_drive"])
        ->where('id', '[0-9]+')->name("get_optical_drive"); // выполнено
    Route::get("/power_supply/{id}", [HardwareController::class, "get_power_supply"])
        ->where('id', '[0-9]+')->name("get_power_supply"); // выполнено
    Route::get("/ram_memory/{id}", [HardwareController::class, "get_ram_memory"])
        ->where('id', '[0-9]+')->name("get_ram_memory"); // выполнено
    Route::get("/sound_card/{id}", [HardwareController::class, "get_sound_card"])
        ->where('id', '[0-9]+')->name("get_sound_card"); // выполнено
    Route::get("/wifi_card/{id}", [HardwareController::class, "get_wifi_card"])
        ->where('id', '[0-9]+')->name("get_wifi_card"); // выполнено
    Route::get("/wired_network_card/{id}", [HardwareController::class, "get_wired_network_card"])
        ->where('id', '[0-9]+')->name("get_wired_network_card"); // выполнено

    Route::post("rating", [HardwareController::class, "add_delete_rating"])->name("rating");
    Route::get("generatePDF/{typeComputerPart}/{idComputerPart}", [PDFController::class, "generatePDF"])
        ->where('typeComputerPart', '[1-9]|1[0-3]')
        ->where('idComputerPart', '[1-9][0-9]*')
        ->name("generatePDF");
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::get("test/{typeComputerPart}/{idComputerPart}", [TestController::class, 'test_get_method'])
    ->where('typeComputerPart', '[1-9]|1[0-3]')
    ->where('idComputerPart', '[1-9][0-9]*')
    ->name("test_get_method");
Route::post("test", [TestController::class, 'test_post_method'])->name("test_post_method");
Route::put("test", [TestController::class, 'test_put_method'])->name("test_put_method");
Route::delete("test", [TestController::class, 'test_delete_method'])->name("test_delete_method");
Route::get("/case_fans", [HardwareController::class, "get_case_fans"])->name("get_case_fans");

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/
