<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->string('payment_gateway')->nullable()->after('user_responded'); // e.g. 'stripe', 'paypal'
            $table->string('gateway_transaction_id')->nullable()->after('payment_gateway'); // session, intent, or txn id
            $table->json('gateway_response')->nullable()->after('gateway_transaction_id'); // store raw response safely
            $table->string('payment_status')->nullable()->after('gateway_response')->default('pending');
        });
    }

    public function down()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn(['payment_gateway', 'gateway_transaction_id', 'gateway_response', 'payment_status']);
        });
    }
};
