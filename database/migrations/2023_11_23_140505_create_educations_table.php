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
            $table->string('level')->nullable();
            $table->string('school_name')->nullable();
            $table->string('address')->nullable();
            $table->date('year_start')->nullable();
            $table->date('year_end')->nullable();
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
