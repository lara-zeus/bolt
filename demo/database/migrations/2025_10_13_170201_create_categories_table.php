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
        Schema::create(config('zeus-bolt.table-prefix').'categories', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->integer('ordering')->default(1);
            $table->boolean('is_active')->default(1);
            $table->text('description')->nullable();
            $table->string('slug');
            $table->string('logo')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(config('zeus-bolt.table-prefix').'categories');
    }
};
