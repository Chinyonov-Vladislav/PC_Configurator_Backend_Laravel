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
        Schema::create('computer_case_drive_bays', function (Blueprint $table) {
            $table->id();
            #$table->unsignedBigInteger("computer_case_id");
            #$table->unsignedBigInteger("drive_bay_id");
            $table->unsignedBigInteger("count");
            $table->foreignId("computer_case_id")->references("id")->on("computer_cases")
                ->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId("drive_bay_id")->references("id")->on("drive_bays")
                ->onDelete("cascade")->onUpdate("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('computer_case_drive_bays');
    }
};
