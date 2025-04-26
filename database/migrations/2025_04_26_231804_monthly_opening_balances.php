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
        Schema::create('monthly_opening_balances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->float('quantity')->default(0);
            $table->unsignedTinyInteger('month'); // من 1 إلى 12
            $table->year('year');
            $table->timestamps();

            // علاقات
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');

            // ضمان عدم تكرار نفس المنتج للشهر والسنة
            $table->unique(['product_id', 'month', 'year']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
