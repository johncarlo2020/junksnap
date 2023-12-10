<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public $tableName = 'collection_images';

    /**
     * Run the migrations.
     * @table cars_images
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
        
            $table->unsignedBigInteger('collection_id'); // Use an unsigned big integer
            $table->string('image');
        
            $table->index(["collection_id"], 'collection-images');
        
            $table->foreign('collection_id', 'collection-images')
                ->references('id')->on('collections')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
        
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->tableName);
    }
};
