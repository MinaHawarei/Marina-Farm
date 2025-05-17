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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('national_id', 14)->unique();
            $table->integer('age');
            $table->text('address')->nullable();
            $table->string('position');
            $table->decimal('salary', 10, 2)->nullable();
            $table->date('hiring_date');
            $table->enum('status', ['نشط', 'غير نشط'])->default('نشط');
            $table->string('marital_status')->nullable();
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
