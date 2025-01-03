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
        Schema::create('report_params', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('user_id');
            $table->unsignedBigInteger('report_id');
            $table->text('description')->nullable();
            $table->string('title');
            $table->string('db_column');
            $table->enum('type', ['boolean', 'date', 'record', 'text'])->nullable();
            $table->string('ref_table')->nullable();
            $table->string('ref_column')->nullable();

            $table->foreign('report_id')->references('id')->on('reports')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('report_params');
    }
};
