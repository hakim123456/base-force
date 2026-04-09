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
        Schema::table('personne', function (Blueprint $table) {
            $table->string('mother_name')->nullable()->after('last_name');
            $table->string('gender')->nullable()->after('mother_name');
            $table->string('marital_status')->nullable()->after('gender');
            $table->string('spouse_name')->nullable()->after('marital_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('personne', function (Blueprint $table) {
            $table->dropColumn(['mother_name', 'gender', 'marital_status', 'spouse_name']);
        });
    }
};
