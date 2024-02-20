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
        Schema::create('computer_case_ports', function (Blueprint $table) {
            $table->id();
            #$table->unsignedBigInteger("computer_case_id");
            #$table->unsignedBigInteger("computer_port_id");
            $table->foreignId("computer_case_id")->references("id")->on("computer_cases")
                ->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId("computer_port_id")->references("id")
                ->on("computer_part_ports")->onDelete("cascade")->onUpdate("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('computer_case_ports');
    }
};
