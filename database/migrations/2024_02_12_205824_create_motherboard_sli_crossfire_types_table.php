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
        Schema::create('motherboard_sli_crossfire_types', function (Blueprint $table) {
            $table->id();
            #$table->unsignedBigInteger("motherboard_id");
            #$table->unsignedBigInteger("sli_crossfire_type_id");
            $table->foreignId("motherboard_id")->references("id")->on("motherboards")
                ->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId("sli_crossfire_type_id")->references("id")->on("sli_crossfire_types")
                ->onDelete("cascade")->onUpdate("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('motherboard_sli_crossfire_types');
    }
};
