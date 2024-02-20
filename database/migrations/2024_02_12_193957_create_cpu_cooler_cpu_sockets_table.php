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
        Schema::create('cpu_cooler_cpu_sockets', function (Blueprint $table) {
            $table->id();
            #$table->unsignedBigInteger("cpu_cooler_id");
            #$table->unsignedBigInteger("socket_id");
            $table->foreignId("cpu_cooler_id")->references("id")->on("cpu_coolers")
                ->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId("socket_id")->references("id")->on("sockets")
                ->onDelete("cascade")->onUpdate("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cpu_cooler_cpu_sockets');
    }
};
