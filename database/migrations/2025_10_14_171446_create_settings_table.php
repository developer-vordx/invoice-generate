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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('company_name')->nullable();
            $table->string('tax_id')->nullable();
            $table->string('country')->nullable();
            $table->string('base_currency')->nullable();
            $table->text('address')->nullable();

            $table->string('logo_path')->nullable();
            $table->text('invoice_notes')->nullable();
            $table->decimal('tax_percentage', 5, 2)->default(0.00);

            // Stripe Integration
            $table->string('stripe_public_key')->nullable();
            $table->string('stripe_secret_key')->nullable();
            $table->string('webhook_url')->nullable();
            $table->string('webhook_secret')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
