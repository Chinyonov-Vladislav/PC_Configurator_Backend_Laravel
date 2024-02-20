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
        Schema::create('wifi_card_securities', function (Blueprint $table) {
            $table->id();
            #$table->unsignedBigInteger("wifi_card_id");
            #$table->unsignedBigInteger("security_id");
            $table->foreignId("wifi_card_id")->references("id")->on("wifi_cards")
                ->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId("security_id")->references("id")->on("securities")
                ->onDelete("cascade")->onUpdate("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wifi_card_securities');
    }
};
