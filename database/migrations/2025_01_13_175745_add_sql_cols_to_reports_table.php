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
            $table->text('select_clause')->nullable();
            $table->text('from_clause')->nullable();
            $table->text('where_clause')->nullable();
            $table->text('groupby_clause')->nullable();
            $table->text('having_clause')->nullable();
            $table->string('sort_by')->nullable()->change();
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
            $table->dropColumn('select_clause');
            $table->dropColumn('from_clause');
            $table->dropColumn('where_clause');
            $table->dropColumn('groupby_clause');
            $table->dropColumn('having_clause');
            $table->string('sort_by')->nullable(false)->change();
        });
    }
};
