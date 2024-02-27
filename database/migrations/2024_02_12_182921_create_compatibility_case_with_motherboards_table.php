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
        Schema::create('compatibility_case_with_motherboards', function (Blueprint $table) {
            $table->id();
            #$table->unsignedBigInteger("motherboard_form_factor_id");
            #$table->unsignedBigInteger("case_id");
            $table->foreignId("form_factor_id")->references("id")->on("computer_part_form_factors")
                ->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId("computer_case_id")->references("id")->on("computer_cases")
                ->onDelete("cascade")->onUpdate("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compability_with_motherboard_form_factors');
    }
};
