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
        Schema::create('live100ms_meetings', function (Blueprint $table) {
            $table->id();
            $table->string('room_id')->nullable();
            $table->unsignedBigInteger('platform_id')->nullable();
            $table->unsignedBigInteger('live_account_id')->nullable();
            $table->unsignedBigInteger('session_id')->nullable();
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->tinyInteger('enabled')->nullable();
            $table->tinyInteger('recording')->nullable();
            $table->string('region')->nullable();
            $table->tinyInteger('large_room')->nullable();
            $table->string('host_code')->nullable();
            $table->string('guest_code')->nullable();
            $table->foreign('platform_id')->references('id')->on('platforms')->onDelete('cascade');
            $table->foreign('live_account_id')->references('id')->on('live_accounts')->onDelete('cascade');
            $table->foreign('session_id')->references('id')->on('platform_sessions')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('live100ms_meetings');
    }
};
