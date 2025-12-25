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
        Schema::create('borrowings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('book_id')->constrained()->cascadeOnDelete();
            $table->timestamp('borrowed_at')->useCurrent();
            $table->date('due_date');
            $table->timestamp('returned_at')->nullable();
            $table->enum('status', ['borrowed', 'returned', 'overdue'])->default('borrowed');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'status']);
            $table->index(['book_id', 'status']);
            $table->index('due_date');
        });

        // Add quantity columns to books table if not exists
        if (!Schema::hasColumn('books', 'total_quantity')) {
            Schema::table('books', function (Blueprint $table) {
                $table->unsignedInteger('total_quantity')->default(1)->after('is_featured');
                $table->unsignedInteger('available_quantity')->default(1)->after('total_quantity');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrowings');

        if (Schema::hasColumn('books', 'total_quantity')) {
            Schema::table('books', function (Blueprint $table) {
                $table->dropColumn(['total_quantity', 'available_quantity']);
            });
        }
    }
};
