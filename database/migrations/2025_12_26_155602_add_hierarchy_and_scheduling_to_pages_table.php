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
            // Hierarchical pages - parent-child relationship
            $table->unsignedBigInteger('parent_id')->nullable()->after('id');
            $table->foreign('parent_id')->references('id')->on('pages')->onDelete('set null');

            // Sort order for organizing pages
            $table->integer('sort_order')->default(0)->after('is_published');

            // Scheduled publishing
            $table->timestamp('publish_at')->nullable()->after('is_published');

            // Meta information for SEO
            $table->string('meta_description')->nullable()->after('content');
            $table->string('featured_image')->nullable()->after('meta_description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
            $table->dropColumn(['parent_id', 'sort_order', 'publish_at', 'meta_description', 'featured_image']);
        });
    }
};
