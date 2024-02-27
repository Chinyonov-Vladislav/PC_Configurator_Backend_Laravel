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
        Schema::create('compatibility_case_with_videocards', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("maximum_length_videocard_in_mm");
            #$table->unsignedBigInteger("computer_case_id");
            $table->foreignId("computer_case_id")->references("id")->on("computer_cases")
                ->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId("compatibility_with_videocard_type_id")->nullable()->references("id")->on("compatibility_with_videocard_types")
                ->onDelete("cascade")->onUpdate("cascade")->name("comp_with_videocard_type_fk");
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compability_case_with_videocards');
    }
};
