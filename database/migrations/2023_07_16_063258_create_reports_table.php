<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->text('description')->nullable();
            $table->timestamps();
            $table->string('title');
            $table->boolean('published')->default(false);
            $table->boolean('show_meta')->default(false);
            $table->boolean('show_print_user')->default(false);
            $table->boolean('show_print_date')->default(false);
            $table->text('select_clause')->nullable();
            $table->text('from_clause')->nullable();
            $table->text('where_clause')->nullable();
            $table->text('groupby_clause')->nullable();
            $table->text('having_clause')->nullable();
            $table->string('order_clause')->nullable();
            $table->unsignedBigInteger('project_id')->nullable();
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reports');
    }
};
