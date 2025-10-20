<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update enum to include new values: viewed, rejected
        DB::statement("ALTER TABLE `invoices` MODIFY COLUMN `status` ENUM('pending','sent','paid','viewed','declined') NOT NULL DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert to old enum
        DB::statement("ALTER TABLE `invoices` MODIFY COLUMN `status` ENUM('pending','sent','paid') NOT NULL DEFAULT 'pending'");
    }
};
