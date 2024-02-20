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
        Schema::create('computer_cases', function (Blueprint $table) {
            $table->id();
            $table->string("image",5000)->nullable();
            $table->string("model",5000)->nullable();
            $table->float("volume")->nullable();
            $table->float("dimension_length")->nullable();
            $table->float("dimension_width")->nullable();
            $table->float("dimension_height")->nullable();
            $table->foreignId("color_id")->nullable()->references("id")->on("colors")
                ->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId("manufacturer_id")->nullable()->references("id")->on("manufacturers")
                ->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId("side_panel_id")->nullable()->references("id")->on("side_panels")
                ->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId("form_factor_id")->nullable()->references("id")->on("computer_part_form_factors")
                ->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId("link_id")->references("id")->on("computer_parts_links")
                ->onDelete("cascade")->onUpdate("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('computer_cases');
    }
};
