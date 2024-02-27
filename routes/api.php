<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HardwareController;
use App\Http\Controllers\ParametersController;
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
Route::post('/login', [AuthController::class, 'login']);
Route::group(['middleware' => ['auth:sanctum']], function () {
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
    Route::get("/wired_network_card", [HardwareController::class, "get_wired_network_cards"])->name("get_wired_network_cards");

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
    Route::get("/wired_network_card_parameters", [ParametersController::class, "get_parameters_wired_network_card"])->name("get_parameters_wired_network_card");

    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::get("test", [TestController::class, 'test_get_method'])->name("test_get_method");
Route::post("test", [TestController::class, 'test_post_method'])->name("test_post_method");
Route::put("test", [TestController::class, 'test_put_method'])->name("test_put_method");
Route::delete("test", [TestController::class, 'test_delete_method'])->name("test_delete_method");
/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/
