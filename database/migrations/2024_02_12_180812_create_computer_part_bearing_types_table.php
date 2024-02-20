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
        Schema::create('computer_part_bearing_types', function (Blueprint $table) {
            $table->id();
            #$table->unsignedBigInteger("computer_part_id");
            #$table->unsignedBigInteger("bearing_type_id");
            $table->foreignId("computer_part_id")->references("id")->on("computer_parts")
                ->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId("bearing_type_id")->references("id")->on("bearing_types")
                ->onDelete("cascade")->onUpdate("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('computer_part_bearing_types');
    }
};
