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
        Schema::create('parent_children', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('chicks_id');
            $table->unsignedBigInteger('parent_id');
            $table->unsignedBigInteger('relations_id');
            $table->timestamps();

            $table->foreign('chicks_id')->references('id')->on('chicks')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('parent_id')->references('id')->on('bird_parents')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('relations_id')->references('id')->on('statuses')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parent_children');
    }
};
