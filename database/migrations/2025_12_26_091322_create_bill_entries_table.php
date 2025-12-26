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
        Schema::create('bill_entries', function (Blueprint $table) {
            $table->id();

            $table->string('bill_entry_no')->unique(); // auto generate
            $table->date('bill_date');

            $table->string('ref_no')->nullable();
            $table->date('ref_date')->nullable();

            $table->unsignedBigInteger('customer_id')->nullable(); // optional (if you already have customers table)
            $table->unsignedBigInteger('cr_account_id'); // chart_of_accounts id

            $table->text('remark')->nullable();

            $table->decimal('total_dr', 12, 2)->default(0);
            $table->decimal('total_cr', 12, 2)->default(0);

            $table->string('status')->default('draft'); // draft/posted (optional future)
            $table->unsignedBigInteger('created_by')->nullable();

            $table->timestamps();

            // If customers table exists, you can uncomment:
            // $table->foreign('customer_id')->references('id')->on('customers');

            // chart_of_accounts FK
            $table->foreign('cr_account_id')->references('id')->on('chart_of_accounts');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bill_entries');
    }
};
