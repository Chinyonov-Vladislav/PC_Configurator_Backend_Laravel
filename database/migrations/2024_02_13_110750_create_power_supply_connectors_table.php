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
        Schema::create('power_supply_connectors', function (Blueprint $table) {
            $table->id();
            #$table->unsignedBigInteger("connector_id");
            #$table->unsignedBigInteger("power_supply_id");
            $table->unsignedBigInteger("count")->nullable();
            $table->foreignId("connector_id")->references("id")->on("computer_part_connectors")
                ->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId("power_supply_id")->references("id")->on("power_supplies")
                ->onDelete("cascade")->onUpdate("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('power_supply_connectors');
    }
};
