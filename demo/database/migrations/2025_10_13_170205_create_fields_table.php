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
        Schema::create(config('zeus-bolt.table-prefix').'fields', function (Blueprint $table) {
            $table->id();
            $table->foreignId('section_id')->constrained(config('zeus-bolt.table-prefix').'sections');
            $table->text('name');
            $table->text('description')->nullable();
            $table->string('type');
            $table->integer('ordering')->default(1);
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
        Schema::dropIfExists(config('zeus-bolt.table-prefix').'fields');
    }
};
