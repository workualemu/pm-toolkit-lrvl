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
        Schema::table('reports', function (Blueprint $table) {
            $table->boolean('published')->default(false)->change();
            $table->boolean('show_meta')->default(false)->change();
            $table->boolean('show_print_user')->default(false)->change();
            $table->boolean('show_print_date')->default(false)->change();
            $table->dropColumn('db_table');
            $table->renameColumn('sort_by', 'order_clause');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reports', function (Blueprint $table) {
            //
        });
    }
};
