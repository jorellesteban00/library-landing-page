<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Modify the status ENUM to include pending and rejected
        DB::statement("ALTER TABLE borrowings MODIFY COLUMN status ENUM('pending', 'borrowed', 'returned', 'overdue', 'rejected') DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to original ENUM values
        DB::statement("ALTER TABLE borrowings MODIFY COLUMN status ENUM('borrowed', 'returned', 'overdue') DEFAULT 'borrowed'");
    }
};
