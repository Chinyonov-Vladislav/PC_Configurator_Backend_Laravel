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
        Schema::create('computer_parts_links', function (Blueprint $table) {
            $table->id();
            $table->string("link", 5000);
            $table->boolean("is_parsed")->default(false);
            #$table->unsignedBigInteger("computer_part_id");
            $table->foreignId("computer_part_id")->references("id")->on("computer_parts")
                ->onDelete("cascade")->onUpdate("cascade");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('computer_parts_links');
    }
};
