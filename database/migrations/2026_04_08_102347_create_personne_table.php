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
        Schema::create('personne', function (Blueprint $table) {
            $table->id();
            $table->string('identifier')->unique()->nullable();
            $table->string('first_name');
            $table->string('father_name')->nullable();
            $table->string('grandfather_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('dob')->nullable();
            $table->string('address')->nullable();
            $table->string('job')->nullable();
            $table->string('phone')->nullable();
            $table->text('social')->nullable();
            $table->text('upbringing')->nullable();
            $table->text('education')->nullable();
            $table->string('level')->nullable();
            $table->text('work_history')->nullable();
            $table->text('religion')->nullable();
            $table->text('dawah')->nullable();
            $table->text('books')->nullable();
            $table->text('travels')->nullable();
            $table->text('friends')->nullable();
            $table->text('notes')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personne');
    }
};
