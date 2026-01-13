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
            $table->decimal('outstanding_amount', 12, 2)->default(0)->after('grand_total');
            $table->decimal('paid_amount', 12, 2)->default(0)->after('outstanding_amount');
            $table->decimal('balance_amount', 12, 2)->default(0)->after('paid_amount');
            //
           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
};
