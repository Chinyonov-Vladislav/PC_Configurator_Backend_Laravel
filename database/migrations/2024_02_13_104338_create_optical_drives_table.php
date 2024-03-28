<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('optical_drives', function (Blueprint $table) {
            $table->id();
            $table->string("image",5000)->nullable();
            $table->string("model",1000)->nullable();
            $table->double("buffer_cache_mb")->nullable();
            $table->unsignedBigInteger("bd_minus_rom_speed")->nullable();
            $table->unsignedBigInteger("dvd_minus_rom_speed")->nullable();
            $table->unsignedBigInteger("cd_minus_rom_speed")->nullable();
            $table->unsignedBigInteger("bd_minus_r_Speed")->nullable();
            $table->unsignedBigInteger("bd_minus_r_dual_layer_speed")->nullable();
            $table->unsignedBigInteger("bd_minus_re_speed")->nullable();
            $table->unsignedBigInteger("bd_minus_re_dual_layer_speed")->nullable();
            $table->unsignedBigInteger("dvd_plus_r_speed")->nullable();
            $table->unsignedBigInteger("dvd_plus_rw_speed")->nullable();
            $table->unsignedBigInteger("dvd_plus_r_dual_layer_speed")->nullable();
            $table->unsignedBigInteger("dvd_minus_rw_speed")->nullable();
            $table->unsignedBigInteger("dvd_minus_r_dual_layer_speed")->nullable();
            $table->unsignedBigInteger("dvd_minus_ram_speed")->nullable();
            $table->unsignedBigInteger("cd_minus_r_speed")->nullable();
            $table->unsignedBigInteger("cd_minus_rw_speed")->nullable();
            $table->unsignedBigInteger("dvd_minus_r_speed")->nullable();
            #$table->unsignedBigInteger("color_id");
            #$table->unsignedBigInteger("manufacturer_id");
            #$table->unsignedBigInteger("form_factor_id");
            #$table->unsignedBigInteger("interface_id");
            $table->foreignId("color_id")->nullable()->references("id")->on("colors")
                ->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId("manufacturer_id")->nullable()->references("id")->on("manufacturers")
                ->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId("form_factor_id")->nullable()->references("id")->on("form_factors")
                ->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId("interface_id")->nullable()->references("id")->on("computer_interfaces")
                ->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId("link_id")->references("id")->on("computer_parts_links")
                ->onDelete("cascade")->onUpdate("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('optical_drives');
    }
};
