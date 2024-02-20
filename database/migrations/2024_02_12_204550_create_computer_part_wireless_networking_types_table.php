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
        Schema::create('computer_part_wireless_networking_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId("computer_part_id")->references("id")->on("computer_parts")
                ->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId("wireless_networking_type_id")->references("id")->on("wireless_networking_types")
                ->onDelete("cascade")->onUpdate("cascade")->name("wireless_net_type_fk");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('computer_part_wireless_networking_types');
    }
};
