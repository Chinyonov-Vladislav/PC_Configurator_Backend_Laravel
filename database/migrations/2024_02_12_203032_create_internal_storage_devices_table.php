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
        Schema::create('internal_storage_devices', function (Blueprint $table) {
            $table->id();
            $table->string("image",5000)->nullable();
            $table->unsignedBigInteger("cache_mb")->nullable();
            $table->unsignedBigInteger("capacity_gb")->nullable();
            $table->decimal("price_for_gb",10)->nullable();
            $table->boolean("nvme")->nullable();
            $table->unsignedBigInteger("full_disk_write_throughput_mb_s")->nullable();
            $table->unsignedBigInteger("full_disk_write_throughput_last_10_seconds_mb_s")->nullable();
            $table->unsignedBigInteger("random_read_throughput_disk_50_full")->nullable();
            $table->unsignedBigInteger("random_write_throughput_disk_50_full")->nullable();
            $table->unsignedBigInteger("sequential_read_throughput_disk_50_full")->nullable();
            $table->unsignedBigInteger("sequential_write_throughput_disk_50_full")->nullable();
            $table->string("model",1000)->nullable();
            $table->boolean("power_loss_protection")->nullable();
            $table->double("hybrid_ssd_cache_mb")->nullable();
            $table->unsignedBigInteger("rpm")->nullable();
            #$table->unsignedBigInteger("form_factor_id");
            #$table->unsignedBigInteger("interface_id");
            #$table->unsignedBigInteger("ssd_controller_id");
            #$table->unsignedBigInteger("type_internal_storage_device_id");
            #$table->unsignedBigInteger("ssd_nand_flash_type_id");
            #$table->unsignedBigInteger("manufacturer_id");
            $table->foreignId("form_factor_id")->nullable()->references("id")->on("form_factors")
                ->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId("interface_id")->nullable()->references("id")->on("computer_interfaces")
                ->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId("ssd_controller_id")->nullable()->references("id")->on("controllers")
                ->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId("type_internal_storage_device_id")->nullable()->references("id")->on("type_internal_storage_devices")
                ->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId("ssd_nand_flash_type_id")->nullable()->references("id")->on("ssd_nand_flash_types")
                ->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId("manufacturer_id")->nullable()->references("id")->on("manufacturers")
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
        Schema::dropIfExists('internal_storage_devices');
    }
};
