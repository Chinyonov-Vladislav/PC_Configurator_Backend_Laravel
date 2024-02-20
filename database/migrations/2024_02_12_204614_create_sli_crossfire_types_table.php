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
        Schema::create('sli_crossfire_types', function (Blueprint $table) {
            $table->id();
            $table->string("name",1000);
            $table->unsignedBigInteger("count_graphical_card");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sli_crossfire_types');
    }
};
