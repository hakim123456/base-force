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
            $table->string('country')->nullable()->after('phone');
            $table->string('governorate')->nullable()->after('country');
            $table->string('delegation')->nullable()->after('governorate');
            $table->string('sector')->nullable()->after('delegation');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('personne', function (Blueprint $table) {
            $table->dropColumn(['country', 'governorate', 'delegation', 'sector']);
        });
    }
};
