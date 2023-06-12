<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('sections', function (Blueprint $table) {
            $table->integer('columns')->default(1);
            $table->text('description')->nullable();
            $table->string('icon')->nullable();
            $table->boolean('aside')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sections', function (Blueprint $table) {
            $table->dropColumn('columns');
            $table->dropColumn('description');
            $table->dropColumn('icon');
            $table->dropColumn('aside');
        });
    }
};
