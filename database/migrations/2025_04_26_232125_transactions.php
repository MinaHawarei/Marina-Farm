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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();

            // نوع العملية (بيع - انتاج - مصروف - إيراد - مرتبات - غيره)
            $table->enum('type', ['production', 'sale', 'expense', 'income', 'salary']);

            // المنتج المرتبط بالعملية (ممكن يبقى نل لو العملية مش مرتبطة بمنتج زي مصروف مثلاً)
            $table->unsignedBigInteger('product_id')->nullable();

            // الكمية (لو العملية مرتبطة بمنتج)
            $table->float('quantity')->nullable();

            // القيمة المالية (المبلغ بالفلوس)
            $table->decimal('amount', 10, 2)->nullable();

            // وصف إضافي للعملية
            $table->text('description')->nullable();

            // تاريخ العملية
            $table->date('date');

            // من أنشأ الحركة
            $table->unsignedBigInteger('created_by');

            $table->timestamps();

            // علاقات
            $table->foreign('product_id')->references('id')->on('products')->onDelete('set null');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
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
