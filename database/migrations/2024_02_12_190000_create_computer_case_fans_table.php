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
        Schema::create('computer_case_fans', function (Blueprint $table) {
            $table->id();
            $table->string("image",5000)->nullable();
            $table->float("airflow_min")->nullable();
            $table->float("airflow")->nullable();
            $table->float("airflow_max")->nullable();
            $table->float("noise_level_min")->nullable();
            $table->float("noise_level")->nullable();
            $table->float("noise_level_max")->nullable();
            $table->unsignedBigInteger("rpm_min")->nullable();
            $table->unsignedBigInteger("rpm")->nullable();
            $table->unsignedBigInteger("rpm_max")->nullable();
            $table->boolean("pmw")->nullable();
            $table->unsignedBigInteger("size_mm")->nullable();
            $table->float("static_pressure")->nullable();
            $table->unsignedBigInteger("quantity_in_pack")->nullable();
            #$table->unsignedBigInteger("color_id");
            #$table->unsignedBigInteger("connector_id");
            #$table->unsignedBigInteger("controller_id");
            #$table->unsignedBigInteger("led_id");
            #$table->unsignedBigInteger("bearing_type_id");
            $table->foreignId("manufacturer_id")->nullable()->references("id")->on("manufacturers")
                ->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId("color_id")->nullable()->references("id")->on("colors")
                ->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId("connector_id")->nullable()->references("id")->on("computer_part_connectors")
                ->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId("controller_id")->nullable()->references("id")->on("computer_part_controllers")
                ->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId("led_id")->nullable()->references("id")->on("leds")
                ->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId("bearing_type_id")->nullable()->references("id")->on("computer_part_bearing_types")
                ->onDelete("cascade")->onUpdate("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('computer_case_fans');
    }
};