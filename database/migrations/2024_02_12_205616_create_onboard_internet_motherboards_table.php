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
        Schema::create('onboard_internet_motherboards', function (Blueprint $table) {
            $table->id();
            #$table->unsignedBigInteger("motherboard_id");
            #$table->unsignedBigInteger("internet_motherboard_id");
            $table->unsignedBigInteger("count");
            $table->foreignId("motherboard_id")->references("id")->on("motherboards")
                ->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId("internet_motherboard_id")->references("id")->on("internet_motherboards")
                ->onDelete("cascade")->onUpdate("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('onboard_internet_motherboards');
    }
};
