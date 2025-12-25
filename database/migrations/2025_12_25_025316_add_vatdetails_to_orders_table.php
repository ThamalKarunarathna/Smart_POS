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
        Schema::table('orders', function (Blueprint $table) {
            //
            $table->boolean('credit_inv')->default(false);
            $table->boolean('vat_applicable')->default(false);
            $table->boolean('sscl_applicable')->default(false);
            $table->decimal('sscl_amount')->nullable();
            $table->decimal('vat_amount')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            //
            $table->dropColumn(['credit_inv', 'vat_applicable', 'sscl_applicable', 'sscl_amount', 'vat_amount']);
        });
    }
};
