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
        Schema::create('request_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('request_id');
            $table->unsignedBigInteger('item_id')->nullable();
            $table->string('item_name');
            $table->integer('quantity');
            $table->float('price')->default(0);
            $table->integer('status')->default(0); // para asa ni uie
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_items');
    }
};
