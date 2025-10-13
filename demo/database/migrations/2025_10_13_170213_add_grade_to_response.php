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
        Schema::table(config('zeus-bolt.table-prefix').'responses', function (Blueprint $table) {
            $table->integer('grades')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(config('zeus-bolt.table-prefix').'responses', function (Blueprint $table) {
            $table->dropColumn('grades');
        });
    }
};
