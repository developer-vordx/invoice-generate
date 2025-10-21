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
        Schema::table('settings', function (Blueprint $table) {
            $table->boolean('enable_terms')->after('webhook_secret')->default(false);
            $table->boolean('enable_invoice_notes')->after('enable_terms')->default(false);
            $table->boolean('enable_tax')->after('enable_invoice_notes')->default(false);
            $table->boolean('enable_tax_id')->after('enable_tax')->default(false);
        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn(['enable_terms', 'enable_invoice_notes', 'enable_tax','enable_tax_id']);
        });
    }
};
