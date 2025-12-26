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
        Schema::create('bill_entry_lines', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('bill_entry_id');
            $table->unsignedBigInteger('dr_account_id'); // chart_of_accounts id
            $table->string('acc_code')->nullable();       // optional input
            $table->string('description')->nullable();
            $table->decimal('dr_amount', 12, 2);

            $table->timestamps();

            $table->foreign('bill_entry_id')->references('id')->on('bill_entries')->onDelete('cascade');
            $table->foreign('dr_account_id')->references('id')->on('chart_of_accounts');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bill_entry_lines');
    }
};
