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
        // Update names to new values
        DB::table('staff_profiles')->where('name', 'Alice Johnson')->update(['name' => 'Nash Roxas']);
        DB::table('staff_profiles')->where('name', 'Bob Smith')->update(['name' => 'Kart Mendoza']);
        DB::table('staff_profiles')->where('name', 'Carol White')->update(['name' => 'Ahron Valenzuela']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert names to original values
        DB::table('staff_profiles')->where('name', 'Nash Roxas')->update(['name' => 'Alice Johnson']);
        DB::table('staff_profiles')->where('name', 'Kart Mendoza')->update(['name' => 'Bob Smith']);
        DB::table('staff_profiles')->where('name', 'Ahron Valenzuela')->update(['name' => 'Carol White']);
    }
};
