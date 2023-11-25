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
        Schema::create('educations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('level');
            $table->string('school_name');
            $table->string('address');
            $table->date('year_start');
            $table->date('year_end');
            $table->string('degree')->nullable();
            $table->string('major')->nullable();
            $table->boolean('is_graduated')->default(false);
            $table->date('date_graduated')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('educations');
    }
};
