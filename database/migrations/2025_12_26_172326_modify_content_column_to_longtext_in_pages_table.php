<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            // Change content column from TEXT to LONGTEXT to support large content
            // with embedded base64 images (LONGTEXT supports up to 4GB)
            $table->longText('content')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            // Revert back to TEXT (note: this may truncate large content)
            $table->text('content')->nullable()->change();
        });
    }
};
