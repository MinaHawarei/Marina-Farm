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
        Schema::create('milk_production_details', function (Blueprint $table) {
            $table->id();
            $table->string('animal_id'); // معرف الحيوان من جدول animals
            $table->foreign('animal_id')->references('animal_code')->on('animals')->onDelete('cascade');
            $table->float('morning_milk')->default(0);
            $table->float('evening_milk')->default(0);
            $table->float('total_milk')->default(0);
            $table->date('date');
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users');
            $table->timestamps();
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
