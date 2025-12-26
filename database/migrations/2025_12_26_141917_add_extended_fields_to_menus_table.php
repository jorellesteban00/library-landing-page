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
        Schema::table('menus', function (Blueprint $table) {
            $table->string('link_type')->default('internal')->after('url'); // 'internal' or 'external'
            $table->text('description')->nullable()->after('link_type'); // Editable content section
            $table->string('target')->default('_self')->after('description'); // '_self' or '_blank'
            $table->boolean('is_visible')->default(true)->after('target'); // Visibility toggle
            $table->string('icon')->nullable()->after('is_visible'); // Optional icon
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('menus', function (Blueprint $table) {
            $table->dropColumn(['link_type', 'description', 'target', 'is_visible', 'icon']);
        });
    }
};
