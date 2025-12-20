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
    Schema::create('orders', function (Blueprint $table) {
        $table->id();

        $table->string('order_no')->unique(); // ORD000001
        $table->foreignId('customer_id')->nullable()->constrained('customers')->nullOnDelete();

        $table->enum('status', ['draft', 'confirmed', 'cancelled'])->default('draft');

        $table->decimal('sub_total', 12, 2)->default(0);
        $table->decimal('discount', 12, 2)->default(0);
        $table->decimal('grand_total', 12, 2)->default(0);

        $table->foreignId('created_by')->constrained('users');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
