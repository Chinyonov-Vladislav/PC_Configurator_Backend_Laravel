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
        Schema::create('frequencies_memory_with_types', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("frequency_mhz");
            #$table->unsignedBigInteger("type_memory_id");
            $table->foreignId("type_memory_id")->references("id")->on("type_memories")
                ->onDelete("cascade")->onUpdate("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('frequencies_memory_with_types');
    }
};
