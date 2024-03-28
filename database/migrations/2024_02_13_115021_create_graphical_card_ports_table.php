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
        Schema::create('graphical_card_ports', function (Blueprint $table) {
            $table->id();
            #$table->unsignedBigInteger("port_id");
            #$table->unsignedBigInteger("graphical_card_id");
            $table->unsignedBigInteger("count");
            $table->foreignId("port_id")->references("id")->on("ports")
                ->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId("graphical_card_id")->references("id")->on("graphical_cards")
                ->onDelete("cascade")->onUpdate("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('graphical_card_ports');
    }
};
