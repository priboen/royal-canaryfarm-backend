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
            $table->unsignedBigInteger('breeder_id');
            $table->unsignedBigInteger('chicks_id');
            $table->string('customer', 255);
            $table->string('phone', 255);
            $table->date('date');
            $table->decimal('price');
            $table->string('payment');
            $table->text('description');
            $table->timestamps();

            $table->foreign('breeder_id')->references('id')->on('breeders')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('chicks_id')->references('id')->on('chicks')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign(['breeder_id', 'chicks_id']);
        });
        Schema::dropIfExists('transactions');
    }
};
