<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(config('zeus-bolt.table-prefix').'forms', function (Blueprint $table) {
            Schema::disableForeignKeyConstraints();
            $table->dropForeign(['user_id']);
            $table->dropForeign(['category_id']);

            $table->unsignedBigInteger('user_id')->nullable()->change();
            Schema::enableForeignKeyConstraints();

            $table->foreign('user_id')
                ->onUpdate('cascade')
                ->nullOnDelete()
                ->references('id')
                ->on('users');

            $table->foreign('category_id')
                ->onUpdate('cascade')
                ->nullOnDelete()
                ->references('id')
                ->on(config('zeus-bolt.table-prefix').'categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
};
