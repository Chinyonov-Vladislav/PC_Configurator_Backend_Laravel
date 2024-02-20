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
        Schema::create('supported_m2_slot_form_factors', function (Blueprint $table) {
            $table->id();
            $table->foreignId("m2_slot_id")->references("id")->on("m2_slots")
                ->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId("m2_form_factor_id")->references("id")->on("m2_form_factors")
                ->onDelete("cascade")->onUpdate("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supported_m2_slot_form_factors');
    }
};
