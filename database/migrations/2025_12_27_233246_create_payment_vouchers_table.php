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
    Schema::create('payment_vouchers', function (Blueprint $table) {
      $table->id();
      $table->string('voucher_no', 50)->unique(); // manual
      $table->date('voucher_date');
      $table->enum('voucher_type', ['PO','GRN','BILL','OTHER']);
      $table->string('payment_type', 50)->nullable(); // cash/cheque/bank etc

      $table->text('description')->nullable();
      $table->decimal('total_value', 15, 2)->default(0);

      $table->foreignId('cr_account_id')->nullable()->constrained('chart_of_accounts');
      $table->foreignId('created_by')->nullable()->constrained('users');

      $table->string('status', 30)->default('Pending'); // Pending/Posted etc
      $table->timestamps();
    });
  }

  public function down(): void {
    Schema::dropIfExists('payment_vouchers');
  }
};
