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
        Schema::table('invoices', function (Blueprint $table) {
            $table->boolean('enable_rush_addon')->default(false)->after('project_address');
            $table->string('rush_delivery_type')->nullable()->after('enable_rush_addon'); // shipping / electronic
            $table->text('rush_description')->nullable()->after('rush_delivery_type');
            $table->decimal('rush_fee', 10, 2)->nullable()->after('rush_description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn([
                'enable_rush_addon',
                'rush_delivery_type',
                'rush_description',
                'rush_fee',
            ]);
        });
    }
};
