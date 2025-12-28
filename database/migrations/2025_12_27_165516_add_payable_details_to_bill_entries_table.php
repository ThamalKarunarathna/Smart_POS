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
        Schema::table('bill_entries', function (Blueprint $table) {
            //
            $table->decimal('payable_amount', 12, 2)->default(0)->after('total_cr');

            $table->string('pay_status', 12)->default(0)->after('payable_amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bill_entries', function (Blueprint $table) {
            //
        });
    }
};
