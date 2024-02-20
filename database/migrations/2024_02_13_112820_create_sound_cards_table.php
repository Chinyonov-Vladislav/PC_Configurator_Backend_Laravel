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
        Schema::create('sound_cards', function (Blueprint $table) {
            $table->id();
            $table->string("image",5000)->nullable();
            $table->string("model",1000)->nullable();
            $table->unsignedBigInteger("value_sample_rate_hz")->nullable();
            $table->float("signal_to_noise_ratio")->nullable();
            #$table->unsignedBigInteger("color_id");
            #$table->unsignedBigInteger("chipset_sound_card_id");
            #$table->unsignedBigInteger("channel_sound_card_id");
            #$table->unsignedBigInteger("interface_id");
            #$table->unsignedBigInteger("sound_card_bit_depth_id");
            #$table->unsignedBigInteger("manufacturer_id");
            $table->foreignId("color_id")->nullable()->references("id")->on("colors")
                ->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId("chipset_sound_card_id")->nullable()->references("id")->on("sound_card_chipsets")
                ->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId("channel_sound_card_id")->nullable()->references("id")->on("sound_card_channels")
                ->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId("interface_id")->nullable()->references("id")->on("computer_part_interfaces")
                ->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId("sound_card_bit_depth_id")->nullable()->references("id")->on("sound_card_bit_depths")
                ->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId("manufacturer_id")->nullable()->references("id")->on("manufacturers")
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
        Schema::dropIfExists('sound_cards');
    }
};
