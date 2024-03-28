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
        Schema::create('motherboards', function (Blueprint $table) {
            $table->id();
            $table->string("image",5000)->nullable();
            $table->string("model",1000)->nullable();
            $table->unsignedBigInteger("count_sockets")->nullable();
            $table->unsignedBigInteger("count_memory_slots")->nullable();
            $table->unsignedBigInteger("memory_max_gb")->nullable();
            $table->boolean("onboard_video")->nullable();
            $table->boolean("support_ecc")->nullable();
            $table->boolean("raid_support")->nullable();
            #$table->unsignedBigInteger("chipset_id");
            #$table->unsignedBigInteger("form_factor_id");
            #$table->unsignedBigInteger("manufacturer_id");
            #$table->unsignedBigInteger("socket_id");
            #$table->unsignedBigInteger("wireless_networking_type_id");
            $table->foreignId("chipset_id")->nullable()->references("id")->on("chipsets")
                ->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId("form_factor_id")->nullable()->references("id")->on("form_factors")
                ->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId("manufacturer_id")->nullable()->references("id")->on("manufacturers")
                ->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId("socket_id")->nullable()->references("id")->on("sockets")
                ->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId("wireless_networking_type_id")->nullable()->references("id")->on("wireless_networking_types")
                ->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId("memory_type_id")->nullable()->references("id")->on("type_memories")
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
        Schema::dropIfExists('motherboards');
    }
};
