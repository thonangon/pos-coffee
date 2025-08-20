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
        Schema::table('menu_item_variations', function (Blueprint $table) {
            $table->unsignedBigInteger('item_id')->after('price'); // Add item_id column after id
            $table->foreign('item_id')->references('id')->on('items')->cascadeOnDelete(); // Foreign key constraint
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('menu_item_variations', function (Blueprint $table) {
            $table->dropForeign(['item_id']); 
            $table->dropColumn('item_id'); 
        });
    }
};
