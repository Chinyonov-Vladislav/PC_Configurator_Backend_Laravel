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
        Schema::create('Compability_cpu_cooler_pc_cases', function (Blueprint $table) {
            $table->id();
            #$table->unsignedBigInteger("cpu_cooler_id");
            #$table->unsignedBigInteger("computer_case_form_factor_id");
            $table->foreignId("cpu_cooler_id")->references("id")->on("cpu_coolers")
                ->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId("pc_case_id")->references("id")->on("computer_cases")
                ->onDelete("cascade")->onUpdate("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cpu_cooler_computer_case_form_factors');
    }
};
