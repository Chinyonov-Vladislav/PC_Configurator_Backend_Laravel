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
        Schema::create('graphical_card_sli_crossfires', function (Blueprint $table) {
            $table->id();
            $table->foreignId("sli_crossfire_type_id")->nullable()->references("id")->on("sli_crossfire_types")
                ->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId("graphical_card_id")->nullable()->references("id")->on("graphical_cards")
                ->onDelete("cascade")->onUpdate("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('graphical_card_sli_crossfires');
    }
};
