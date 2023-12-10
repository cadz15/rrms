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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('id_number')->nullable();
            $table->string('password')->nullable();
            $table->unsignedBigInteger('role_id');
            $table->string('first_name', 100);
            $table->string('middle_name', 100)->nullable();
            $table->string('last_name', 100);
            $table->string('suffix', 10)->nullable();
            $table->string('sex', 10);
            $table->string('contact_number', 20);
            $table->date('birth_date');
            $table->string('birth_place', 250);
            $table->string('address', 250);
            $table->boolean('is_approved')->default(false);
            $table->text('reason')->nullable(); // if requestor's data is disapproved
            $table->unsignedBigInteger('approved_by')->nullable()->comment('ID the one who approved the student, might the ID of the employee');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
