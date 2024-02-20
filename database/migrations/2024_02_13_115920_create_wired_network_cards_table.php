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
        Schema::create('wired_network_cards', function (Blueprint $table) {
            $table->id();
            $table->string("image",5000)->nullable();
            $table->string("model",1000)->nullable();
            #$table->unsignedBigInteger("manufacturer_id");
            #$table->unsignedBigInteger("color_id");
            #$table->unsignedBigInteger("interface_id");
            $table->foreignId("manufacturer_id")->nullable()->references("id")->on("manufacturers")
                ->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId("color_id")->nullable()->references("id")->on("colors")
                ->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId("interface_id")->nullable()->references("id")->on("computer_part_interfaces")
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
        Schema::dropIfExists('wired_network_cards');
    }
};
