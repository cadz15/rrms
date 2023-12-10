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
            $table->string('year_level')->nullable();
            $table->string('school_name')->nullable();
            $table->string('address')->nullable();
            $table->date('year_start')->nullable();
            $table->date('year_end')->nullable();
            $table->string('major_id')->nullable();
            $table->boolean('is_graduated')->default(false);
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
