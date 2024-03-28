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
        Schema::create('cpu_coolers', function (Blueprint $table) {
            $table->id();
            $table->string("image",5000)->nullable();
            $table->boolean("fanless")->nullable();
            $table->unsignedBigInteger("fan_rpm_min")->nullable();
            $table->unsignedBigInteger("fan_rpm_max")->nullable();
            $table->unsignedBigInteger("fan_rpm")->nullable();
            $table->unsignedBigInteger("height_mm")->nullable();
            $table->double("noise_level_min")->nullable();
            $table->double("noise_level_max")->nullable();
            $table->double("noise_level")->nullable();
            $table->unsignedBigInteger("radiator_size")->nullable();
            $table->boolean("water_cooled")->nullable();
            $table->string("model")->nullable();
            #$table->unsignedBigInteger("color_id");
            #$table->unsignedBigInteger("manufacturer_id");
            #$table->unsignedBigInteger("bearing_type_id");
            $table->foreignId("color_id")->nullable()->references("id")->on("colors")
                ->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId("manufacturer_id")->nullable()->references("id")->on("manufacturers")
                ->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId("bearing_type_id")->nullable()->references("id")->on("bearing_types")
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
        Schema::dropIfExists('cpu_coolers');
    }
};
