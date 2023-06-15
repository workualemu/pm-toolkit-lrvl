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
        Schema::create('kanban_lists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->text('description');
            $table->timestamps();
            $table->string('value');
            $table->integer('rank')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kanban_lists');
    }
};
