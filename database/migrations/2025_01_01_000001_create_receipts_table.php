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
        Schema::create('receipts', function (Blueprint $table) {
            $table->id();
            $table->string('receipt_no', 50)->unique();
            $table->date('receipt_date');
            $table->foreignId('customer_id')->constrained('customers')->cascadeOnDelete();
            $table->decimal('received_amount', 15, 2)->default(0);
            $table->enum('payment_type', ['cash', 'bank', 'cheque'])->default('cash');

            // For cheque
            $table->string('cheque_no')->nullable();
            $table->date('cheque_date')->nullable();
            $table->string('cheque_bank')->nullable();

            // For bank
            $table->foreignId('bank_id')->nullable()->constrained('chart_of_accounts')->nullOnDelete();

            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receipts');
    }
};

