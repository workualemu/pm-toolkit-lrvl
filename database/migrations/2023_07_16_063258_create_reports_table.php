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
            $table->foreignId('user_id');
            $table->text('description');
            $table->timestamps();
            $table->string('title');
            $table->string('db_table');
            $table->string('sort_by');
            $table->boolean('published');
            $table->boolean('show_meta');
            $table->boolean('show_print_user');
            $table->boolean('show_print_date');

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
