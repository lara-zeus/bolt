<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table(config('zeus-bolt.table-prefix').'responses', function (Blueprint $table) {
            $table->integer('extension_item_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table(config('zeus-bolt.table-prefix').'responses', function (Blueprint $table) {
            $table->dropColumn('extension_item_id');
        });
    }
};
