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
        Schema::create('computer_part_controllers', function (Blueprint $table) {
            $table->id();
            #$table->unsignedBigInteger("computer_part_id");
            #$table->unsignedBigInteger("controller_id");
            $table->foreignId("computer_part_id")->references("id")->on("computer_parts")->onUpdate("cascade")->onDelete("cascade");
            $table->foreignId("controller_id")->references("id")->on("controllers")->onUpdate("cascade")->onDelete("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('computer__part_controllers');
    }
};
