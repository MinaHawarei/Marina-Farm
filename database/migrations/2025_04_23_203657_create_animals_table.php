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
        Schema::create('animals', function (Blueprint $table) {
            $table->id();
            $table->string('animal_code')->unique();
            $table->string('type');
            $table->string('breed')->nullable();
            $table->integer('age');
            $table->float('weight');
            $table->string('health_status')->nullable();
            $table->string('gender');
            $table->string('origin');
            $table->date('arrival_date');
            $table->string('status');
            $table->string('pen_id');
            $table->string('insemination_type');
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
        Schema::dropIfExists('animals');
    }
};
