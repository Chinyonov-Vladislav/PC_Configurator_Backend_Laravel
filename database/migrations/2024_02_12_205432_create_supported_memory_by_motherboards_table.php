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
        Schema::create('supported_memory_by_motherboards', function (Blueprint $table) {
            $table->id();
            #$table->unsignedBigInteger("motherboard_id");
            #$table->unsignedBigInteger("frequency_memory_with_type_id");
            $table->foreignId("motherboard_id")->references("id")->on("motherboards")
                ->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId("frequency_memory_type_id")->references("id")->on("frequencies_memory_with_types")
                ->onDelete("cascade")->onUpdate("cascade")->name("freq_memory_fk");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supported_memory_by_motherboards');
    }
};
