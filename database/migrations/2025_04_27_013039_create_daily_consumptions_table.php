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
        Schema::create('daily_consumptions', function (Blueprint $table) {
            $table->id();
            $table->float('hay');
            $table->float('feed');
            $table->float('clover');
            $table->float('gasoline');
            $table->float('gas');
            $table->date('consumptions_date')->unique();
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
        Schema::dropIfExists('daily_consumptions');
    }
};
