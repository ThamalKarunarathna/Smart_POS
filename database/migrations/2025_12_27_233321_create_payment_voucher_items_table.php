<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
    Schema::create('payment_voucher_items', function (Blueprint $table) {
      $table->id();
      $table->foreignId('payment_voucher_id')->constrained('payment_vouchers')->cascadeOnDelete();

      // For PO/GRN/BILL selections
      $table->enum('ref_type', ['PO','GRN','BILL','OTHER']);
      $table->unsignedBigInteger('ref_id')->nullable();

      // For OTHER
      $table->string('payee')->nullable();
      $table->foreignId('dr_account_id')->nullable()->constrained('chart_of_accounts');

      $table->decimal('amount', 15, 2)->default(0);
      $table->timestamps();

      $table->index(['ref_type','ref_id']);
    });
  }

  public function down(): void {
    Schema::dropIfExists('payment_voucher_items');
  }
};
