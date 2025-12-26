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
        Schema::create('chart_of_accounts', function (Blueprint $table) {
    $table->id();

    $table->string('account_code')->unique();   // 1001, 2001, etc
    $table->string('account_name');

    $table->enum('account_type', [
        'ASSET',
        'LIABILITY',
        'EQUITY',
        'INCOME',
        'EXPENSE'
    ]);

    $table->foreignId('parent_id')
          ->nullable()
          ->constrained('chart_of_accounts')
          ->nullOnDelete();

    $table->boolean('is_system')->default(false);
    $table->boolean('is_active')->default(true);

    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('chart_of_accounts', function (Blueprint $table) {
            //
        });
    }
};
