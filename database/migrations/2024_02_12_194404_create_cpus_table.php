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
        Schema::create('cpus', function (Blueprint $table) {
            $table->id();

            $table->string("image",5000)->nullable();
            $table->float("performance_core_clock_ghz")->nullable();
            $table->unsignedBigInteger("core_count")->nullable();
            $table->float("performance_boost_clock_ghz")->nullable();
            $table->unsignedBigInteger("tdp_w")->nullable();
            $table->boolean("includes_cooler")->nullable();
            $table->boolean("ecc_support")->nullable();
            $table->unsignedBigInteger("maximum_supported_memory_gb")->nullable();
            $table->unsignedBigInteger("l1_cache_performance_data_kbs")->nullable();
            $table->unsignedBigInteger("l1_cache_performance_instruction_kbs")->nullable();
            $table->float("l1_cache_efficiency_instruction_kbs")->nullable();
            $table->float("l1_cache_efficiency_data_kbs")->nullable();
            $table->float("l2_cache_performance_mbs")->nullable();
            $table->float("l2_cache_efficiency_mbs")->nullable();
            $table->float("l3_cache_mbs")->nullable();
            $table->unsignedBigInteger("lithography_nm")->nullable();
            $table->boolean("multithreading")->nullable();
            $table->boolean("SMT")->nullable();
            $table->boolean("includes_cpu_cooler")->nullable();
            $table->string("model",1000)->nullable();
            #$table->unsignedBigInteger("manufacturer_id")->nullable();
            #$table->unsignedBigInteger("core_family_id")->nullable();
            #$table->unsignedBigInteger("integrated_graphic_id")->nullable();
            #$table->unsignedBigInteger("microarchitecture_id")->nullable();
            #$table->unsignedBigInteger("packaging_id")->nullable();
            #$table->unsignedBigInteger("series_id")->nullable();
            #$table->unsignedBigInteger("socket_id")->nullable();
            $table->foreignId("manufacturer_id")->nullable()->references("id")->on("manufacturers")
                ->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId("core_family_id")->nullable()->references("id")->on("core_families")
                ->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId("integrated_graphic_id")->nullable()->references("id")->on("integrated_graphics")
                ->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId("microarchitecture_id")->nullable()->references("id")->on("microarchitectures")
                ->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId("packaging_id")->nullable()->references("id")->on("packagings")
                ->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId("series_id")->nullable()->references("id")->on("series")
                ->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId("socket_id")->nullable()->references("id")->on("sockets")
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
        Schema::dropIfExists('cpus');
    }
};
