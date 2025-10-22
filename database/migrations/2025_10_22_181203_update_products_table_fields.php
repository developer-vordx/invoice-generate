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
        Schema::table('products', function (Blueprint $table) {
            // Remove old/unnecessary columns if they exist
            if (Schema::hasColumn('products', 'sku')) {
                $table->dropColumn('sku');
            }
            if (Schema::hasColumn('products', 'stock')) {
                $table->dropColumn('stock');
            }

            // Add new columns if they don't exist
            if (!Schema::hasColumn('products', 'category')) {
                $table->string('category')
                    ->nullable()
                    ->after('price')
                    ->comment('Product category name or type');
            }

            if (!Schema::hasColumn('products', 'is_active')) {
                $table->boolean('is_active')
                    ->default(true)
                    ->after('category')
                    ->comment('Whether the product is active/visible');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Rollback changes
            if (Schema::hasColumn('products', 'category')) {
                $table->dropColumn('category');
            }

            if (Schema::hasColumn('products', 'is_active')) {
                $table->dropColumn('is_active');
            }

            // Optionally restore dropped columns
            if (!Schema::hasColumn('products', 'sku')) {
                $table->string('sku')->nullable()->after('name');
            }

            if (!Schema::hasColumn('products', 'stock')) {
                $table->integer('stock')->default(0)->after('price');
            }
        });
    }
};
