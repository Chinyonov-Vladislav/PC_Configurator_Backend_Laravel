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
        Schema::create('rams', function (Blueprint $table) {
            $table->id();
            $table->string("image",5000)->nullable();
            $table->string("model",1000)->nullable();
            $table->unsignedBigInteger("total_capacity_memory")->nullable();
            $table->double("cas_latency")->nullable();
            $table->double("first_word_latency")->nullable();
            $table->boolean("heat_spreader")->nullable();
            $table->double("voltage")->nullable();
            $table->double("price_gb")->nullable();
            #$table->unsignedBigInteger("color_id");
            #$table->unsignedBigInteger("manufacturer_id");
            #$table->unsignedBigInteger("form_factor_id");
            #$table->unsignedBigInteger("module_id");
            #$table->unsignedBigInteger("timing_id");
            #$table->unsignedBigInteger("speed_ram_id");
            #$table->unsignedBigInteger("ecc_registered_type_id");
            $table->foreignId("color_id")->nullable()->references("id")->on("colors")
                ->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId("manufacturer_id")->nullable()->references("id")->on("manufacturers")
                ->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId("form_factor_id")->nullable()->references("id")->on("form_factors")
                ->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId("module_id")->nullable()->references("id")->on("ram_modules")
                ->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId("timing_id")->nullable()->references("id")->on("ram_timings")
                ->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId("speed_ram_id")->nullable()->references("id")->on("frequencies_memory_with_types")
                ->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId("ecc_registered_type_id")->nullable()->references("id")->on("ram_ecc_registered_types")
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
        Schema::dropIfExists('rams');
    }
};
