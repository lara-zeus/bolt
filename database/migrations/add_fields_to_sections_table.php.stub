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
            $table->integer('section_column')->default(1);
            $table->text('section_descriptions')->nullable();
            $table->string('section_icon')->nullable();
            $table->boolean('section_aside')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sections', function (Blueprint $table) {
            $table->dropColumn('section_column');
            $table->dropColumn('section_descriptions');
            $table->dropColumn('section_icon');
            $table->dropColumn('section_aside');
        });
    }
};
