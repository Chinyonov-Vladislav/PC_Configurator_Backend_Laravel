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
        Schema::create('graphical_cards', function (Blueprint $table) {
            $table->id();
            $table->string("image",5000)->nullable();
            $table->double("count_memory_gb")->nullable();
            $table->unsignedBigInteger("clock_core_mhz")->nullable();
            $table->unsignedBigInteger("boost_clock_mhz")->nullable();
            $table->unsignedBigInteger("length_mm")->nullable();
            $table->unsignedBigInteger("TDP_w")->nullable();
            $table->unsignedBigInteger("total_slot_width")->nullable();
            $table->unsignedBigInteger("case_expansion_slot_width")->nullable();
            $table->unsignedBigInteger("effective_memory_clock_mhz")->nullable();
            $table->string("model",1000)->nullable();
            #$table->unsignedBigInteger("manufacturer_id");
            #$table->unsignedBigInteger("chipset_id");
            #$table->unsignedBigInteger("color_id");
            #$table->unsignedBigInteger("cooling_type_id");
            #$table->unsignedBigInteger("external_power_type_id");
            #$table->unsignedBigInteger("memory_type_id");
            #$table->unsignedBigInteger("frame_sync_type_id");
            #$table->unsignedBigInteger("interface_id");
            #$table->unsignedBigInteger("sli_crossfire_type_id");
            $table->foreignId("manufacturer_id")->nullable()->references("id")->on("manufacturers")
                ->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId("chipset_id")->nullable()->references("id")->on("chipsets")
                ->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId("color_id")->nullable()->references("id")->on("colors")
                ->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId("cooling_type_id")->nullable()->references("id")->on("cooling_types")
                ->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId("external_power_type_id")->nullable()->references("id")->on("graphical_card_external_power_types")
                ->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId("memory_type_id")->nullable()->references("id")->on("graphical_card_memory_types")
                ->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId("frame_sync_type_id")->nullable()->references("id")->on("frame_sync_types")
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
        Schema::dropIfExists('graphical_cards');
    }
};
