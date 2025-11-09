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
        Schema::table('users', function (Blueprint $table) {
            $table->string('display_name')->nullable();
            $table->string('full_name')->nullable();
            $table->string('phone_number', 50)->nullable();
            $table->timestamp('last_login_at')->nullable();
            $table->boolean('two_factor_enabled')->default(false);
            $table->string('two_factor_method')->nullable();
            $table->text('two_factor_secret')->nullable();
            $table->text('two_factor_recovery_codes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'display_name',
                'full_name',
                'phone_number',
                'last_login_at',
                'two_factor_enabled',
                'two_factor_method',
                'two_factor_secret',
                'two_factor_recovery_codes',
            ]);
        });
    }
};
