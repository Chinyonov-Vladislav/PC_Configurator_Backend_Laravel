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
        Schema::create('motherboard_interfaces', function (Blueprint $table) {
            $table->id();
            #$table->unsignedBigInteger("motherboard_id");
            #$table->unsignedBigInteger("interface_id");
            $table->unsignedBigInteger("count");
            $table->foreignId("motherboard_id")->references("id")->on("motherboards")
                ->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId("interface_id")->references("id")->on("computer_part_interfaces")
                ->onDelete("cascade")->onUpdate("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('motherboard_interfaces');
    }
};
