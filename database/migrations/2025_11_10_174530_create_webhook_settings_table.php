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
        Schema::create('webhook_settings', function (Blueprint $table) {
            $table->id();

            // Optional multi-tenant support
//            $table->foreignId('organization_id')->nullable()->constrained()->onDelete('cascade');

            // Webhook configuration
            $table->string('webhook_url')->nullable();
            $table->string('webhook_secret')->nullable();

            // Customer event toggles
            $table->boolean('enable_customer_create')->default(false);
            $table->boolean('enable_customer_update')->default(false);
            $table->boolean('enable_customer_delete')->default(false);

            // Product event toggles
            $table->boolean('enable_product_create')->default(false);
            $table->boolean('enable_product_update')->default(false);
            $table->boolean('enable_product_delete')->default(false);

            // Invoice event toggles
            $table->boolean('enable_invoice_create')->default(false);
            $table->boolean('enable_invoice_update')->default(false);
            $table->boolean('enable_invoice_delete')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('webhook_settings');
    }
};
