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
        Schema::create('wifi_cards', function (Blueprint $table) {
            $table->id();
            $table->string("image",5000)->nullable();
            $table->string("model",1000)->nullable();
            #$table->unsignedBigInteger("interface_id");
            #$table->unsignedBigInteger("manufacturer_id");
            #$table->unsignedBigInteger("protocol_id");
            #$table->unsignedBigInteger("operating_range_id");
            #$table->unsignedBigInteger("color_id");
            $table->foreignId("interface_id")->nullable()->references("id")->on("computer_part_interfaces")
                ->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId("manufacturer_id")->nullable()->references("id")->on("manufacturers")
                ->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId("protocol_id")->nullable()->references("id")->on("computer_part_wireless_networking_types")
                ->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId("operating_range_id")->nullable()->references("id")->on("operating_ranges")
                ->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId("color_id")->nullable()->references("id")->on("colors")
                ->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId("antenna_id")->nullable()->references("id")->on("wifi_card_antennas")
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
        Schema::dropIfExists('wifi_cards');
    }
};
