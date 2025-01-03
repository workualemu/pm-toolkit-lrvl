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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('original_id')->nullable();
            $table->foreignId('user_id');
            $table->text('description')->nullable();
            $table->timestamps();
            $table->string('title');
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->timestamp('actual_start_date')->nullable();
            $table->timestamp('actual_end_date')->nullable();
            $table->float('budget')->default(0);
            $table->float('expense')->default(0);
            $table->foreignId('parent')->nullable();
            $table->foreignId('project_id');
            $table->foreignId('assigned_to')->nullable();
            $table->foreignId('report_by')->nullable();
            $table->foreignId('task_type_id')->nullable();
            $table->foreignId('task_status_id')->nullable();
            $table->foreignId('task_priority_id')->nullable();
            $table->integer('duration')->default(1);
            $table->float('progress')->default(0);
            $table->integer('kanban_list_rank')->default(1);
            $table->string('text')->nullable();
            $table->string('type')->nullable();
            $table->integer('level')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
