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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('menu_name');
            $table->timestamps();
        });

        Schema::create('item_categories', function (Blueprint $table) {
            $table->id();
            $table->string('category_name');
            $table->timestamps();
        });

        Schema::create('menu_item_variations', function (Blueprint $table) {
            $table->id();
            $table->string('variation_name');
            $table->decimal('price', 16, 2);
            
            $table->timestamps();
        });

        Schema::create('modifier_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('modifier_options', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('modifier_group_id');
            $table->foreign('modifier_group_id')->references('id')->on('modifier_groups')->onUpdate('cascade')->onDelete('cascade');
            $table->string('name');
            $table->decimal('price', 16, 2);
            $table->boolean('is_available')->default(true);
            $table->integer('sort_order')->default(0);
            $table->boolean('is_preselected')->default(false);
            $table->timestamps();
        });

        
        Schema::create('item_modifiers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('item_id')->nullable();
            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('modifier_group_id')->nullable();
            $table->foreign('modifier_group_id')->references('id')->on('modifier_groups')->onDelete('cascade')->onUpdate('cascade');
            $table->boolean('is_required')->default(false);
            $table->boolean('allow_multiple_selection')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
        Schema::dropIfExists('item_categories');
        Schema::dropIfExists('menu_item_variations');
        Schema::dropIfExists('modifier_groups');
        Schema::dropIfExists('modifier_options');
        Schema::dropIfExists('item_modifiers');

 
    }
};
