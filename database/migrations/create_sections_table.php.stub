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
        Schema::create(config('zeus-bolt.table-prefix').'sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('form_id')->constrained(config('zeus-bolt.table-prefix').'forms');
            $table->text('name')->nullable();
            $table->integer('ordering')->default(1);
            $table->integer('columns')->default(1);
            $table->text('description')->nullable();
            $table->string('icon')->nullable();
            $table->boolean('aside')->default(0);
            $table->boolean('borderless')->default(0);
            $table->boolean('compact')->default(0);
            $table->text('options')->nullable();
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
        Schema::dropIfExists(config('zeus-bolt.table-prefix').'sections');
    }
};
