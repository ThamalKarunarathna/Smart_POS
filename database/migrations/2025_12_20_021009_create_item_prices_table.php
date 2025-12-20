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
    Schema::create('item_prices', function (Blueprint $table) {
        $table->id();
        $table->foreignId('item_id')->constrained()->onDelete('cascade');
        $table->decimal('selling_price', 12, 2);
        $table->decimal('cost_price', 12, 2)->nullable();
        $table->date('effective_from');
        $table->boolean('is_active')->default(true);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_prices');
    }
};
