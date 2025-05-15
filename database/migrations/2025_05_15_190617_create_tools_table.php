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
        Schema::create('tools', function (Blueprint $table) {
             $table->id(); // مفتاح أساسي
            $table->string('name'); // اسم الأداة
            $table->text('description')->nullable(); // وصف الأداة
            $table->string('category'); // فئة الأداة
            $table->decimal('price', 8, 2)->nullable(); // سعر الأداة
            $table->boolean('available')->default(true); // هل الأداة متاحة؟
            $table->date('last_maintenance_at')->nullable(); // تاريخ آخر صيانة
            $table->integer('lifespan_years')->nullable(); // العمر الافتراضي بالأعوام
            $table->integer('maintenance_frequency')->default('monthly'); // معدل الصيانة (شهري، سنوي...)
            $table->timestamps(); // وقت الإنشاء والتحديث
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tools');
    }
};
