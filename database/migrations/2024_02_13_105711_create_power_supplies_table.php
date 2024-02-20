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
        Schema::create('power_supplies', function (Blueprint $table) {
            $table->id();
            $table->string("image",5000)->nullable();
            $table->unsignedBigInteger("wattage_w")->nullable();
            $table->unsignedBigInteger("length_mm")->nullable();
            $table->unsignedBigInteger("efficiency_percent")->nullable();
            $table->boolean("fanless")->nullable();
            $table->string("model",1000)->nullable();
            #$table->unsignedBigInteger("color_id");
            #$table->unsignedBigInteger("manufacturer_id");
            #$table->unsignedBigInteger("efficiency_rating_id");
            #$table->unsignedBigInteger("modular_type_id");
            #$table->unsignedBigInteger("form_factor_id");
            $table->foreignId("color_id")->nullable()->references("id")->on("colors")
                ->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId("manufacturer_id")->nullable()->references("id")->on("manufacturers")
                ->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId("efficiency_rating_id")->nullable()->references("id")->on("efficiency_ratings")
                ->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId("modular_type_id")->nullable()->references("id")->on("modular_power_supply_types")
                ->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId("form_factor_id")->nullable()->references("id")->on("computer_part_form_factors")
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
        Schema::dropIfExists('power_supplies');
    }
};
