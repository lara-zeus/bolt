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
        Schema::create(config('zeus-bolt.table-prefix').'field_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('form_id')->constrained(config('zeus-bolt.table-prefix').'forms');
            $table->foreignId('field_id')->constrained(config('zeus-bolt.table-prefix').'fields');
            $table->foreignId('response_id')->constrained(config('zeus-bolt.table-prefix').'responses');
            $table->longText('response');
            $table->integer('grade')->nullable();
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
        Schema::dropIfExists(config('zeus-bolt.table-prefix').'field_responses');
    }
};
