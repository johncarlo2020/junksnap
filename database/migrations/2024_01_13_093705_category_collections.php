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
        Schema::create('category_collections', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('collection_id');
            $table->unsignedBigInteger('category_id');
            $table->timestamps();
        
            $table->index(["collection_id"], 'collection-category');
            $table->index(["category_id"], 'category-category_collections');
        
            $table->foreign('collection_id', 'collection-category')
                ->references('id')->on('collections')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        
            $table->foreign('category_id', 'category-category_collections')
                ->references('id')->on('categories')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
