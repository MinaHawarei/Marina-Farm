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
        Schema::create('daily_sales', function (Blueprint $table) {
            $table->id(); // مفتاح أساسي
            $table->unsignedBigInteger('production_id'); // مرجع لإنتاج يومي
            $table->foreign('production_id')->references('id')->on('daily_productions');

            $table->string('category');
            $table->string('type');
            $table->float('quantity');
            $table->float('unit_price'); // سعر الوحدة
            $table->float('amount');
            $table->float('paid');
            $table->float('remaining');
            $table->date('date');
            $table->string('sales_point')->nullable(); // منفذ البيع
            $table->string('buyer_name');
            $table->unsignedBigInteger('buyer_id')->nullable();
            $table->foreign('buyer_id')->references('id')->on('buyers');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('created_by'); // مرجع للمستخدم الذي أضاف البيع
            $table->foreign('created_by')->references('id')->on('users');
            $table->timestamps(); // created_at و updated_at

        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_sales');
    }
};
