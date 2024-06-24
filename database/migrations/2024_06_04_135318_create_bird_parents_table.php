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
        Schema::create('bird_parents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('breeder_id');
            $table->string('ring_number', 255)->nullable();
            $table->string('photo', 255);
            $table->decimal('price', 8, 2)->default(0.00);
            $table->date('date_of_birth');
            $table->string('gender', 255)->nullable();
            $table->string('canary_type', 255)->nullable();
            $table->text('type_description')->nullable();
            $table->timestamps();

            $table->foreign('breeder_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bird_parents', function (Blueprint $table) {
            $table->dropForeign(['breeder_id']);
        });
        Schema::dropIfExists('bird_parents');
    }
};
