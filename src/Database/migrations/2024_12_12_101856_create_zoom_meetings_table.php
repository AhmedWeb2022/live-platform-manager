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
        Schema::create('zoom_meetings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('platform_id')->nullable();
            $table->unsignedBigInteger('live_account_id')->nullable();
            $table->unsignedBigInteger('session_id')->nullable();
            $table->string('uuid', 64)->unique()->nullable(); // Unique identifier
            $table->bigInteger('zoom_id')->unique()->nullable(); // Zoom meeting ID
            $table->string('host_id')->nullable(); // Host ID
            $table->string('host_email')->nullable(); // Host email
            $table->string('topic')->nullable(); // Meeting topic
            $table->tinyInteger('type')->nullable(); // Meeting type
            $table->string('status')->default('waiting')->nullable(); // Meeting status
            $table->timestamp('start_time')->nullable(); // Meeting start time
            $table->integer('duration')->nullable(); // Duration in minutes
            $table->string('timezone')->nullable(); // Timezone
            $table->text('agenda')->nullable(); // Meeting agenda
            $table->text('start_url')->nullable(); // Start URL
            $table->text('join_url')->nullable(); // Join URL
            $table->string('password', 10)->nullable(); // Meeting password
            $table->string('h323_password', 10)->nullable(); // H.323/SIP password
            $table->string('pstn_password', 10)->nullable(); // PSTN password
            $table->string('encrypted_password')->nullable(); // Encrypted password
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
        Schema::dropIfExists('zoom_meetings');
    }
};
