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
        Schema::table('live_accounts', function (Blueprint $table) {
            $table->string('dev_link')->nullable()->after('join_url')->comment('For Development Testing');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('live_accounts', function (Blueprint $table) {
            $table->dropColumn('dev_link');
        });
    }
};
