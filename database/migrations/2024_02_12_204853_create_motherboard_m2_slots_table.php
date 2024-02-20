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
        Schema::create('motherboard_m2_slots', function (Blueprint $table) {
            $table->id();
            $table->foreignId("m2_slot_id")->references("id")->on("m2_slots")
                ->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId("motherboard_id")->references("id")->on("motherboards")
                ->onDelete("cascade")->onUpdate("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('motherboard_m2_slots');
    }
};
