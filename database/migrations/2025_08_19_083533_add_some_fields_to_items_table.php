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
        Schema::table('items', function (Blueprint $table) {
            $table->string('image')->nullable()->after('price');
            $table->text('description')->nullable()->after('image');
            $table->unsignedBigInteger('menu_id')->after('description'); 
            $table->foreign('menu_id')->references('id')->on('menus')->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedBigInteger('item_category_id')->after('menu_id'); 
            $table->foreign('item_category_id')->references('id')->on('item_categories')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn('image');
            $table->dropColumn('description');
            $table->dropForeign(['menu_id']);
            $table->dropColumn('menu_id');

            $table->dropForeign(['item_category_id']);
            $table->dropColumn('item_category_id');
        });
    }
};
