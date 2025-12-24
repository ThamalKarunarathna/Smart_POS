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
        Schema::table('purchase_orders', function (Blueprint $table) {
            $table->decimal('sub_total', 12, 2)->default(0)->after('po_date');

            $table->decimal('delivery_amount', 12, 2)->default(0)->after('sub_total');

            $table->boolean('sscl_enabled')->default(false)->after('delivery_amount');
            $table->decimal('sscl_amount', 12, 2)->default(0)->after('sscl_enabled');

            $table->boolean('vat_enabled')->default(false)->after('sscl_amount');
            $table->decimal('vat_amount', 12, 2)->default(0)->after('vat_enabled');

            $table->decimal('grand_total', 12, 2)->default(0)->after('vat_amount');
        });
    }

    public function down(): void
    {
        Schema::table('purchase_orders', function (Blueprint $table) {
            $table->dropColumn([
                'sub_total',
                'delivery_amount',
                'sscl_enabled',
                'sscl_amount',
                'vat_enabled',
                'vat_amount',
                'grand_total',
            ]);
        });
    }
};
