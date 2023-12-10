<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public $tableName = 'collections';

    /**
     * Run the migrations.
     * @table cars_types
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('collector_id')->nullable();
            $table->unsignedBigInteger('seller_id');
            $table->integer('seller_lat');
            $table->integer('seller_lng');
            $table->string('description');
            $table->string('weight');
        
            $table->index(["collector_id"], 'collection-collector');
            $table->index(["seller_id"], 'collection-seller');
        
            $table->foreign('collector_id', 'collection-collector')
                ->references('id')->on('users')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        
            $table->foreign('seller_id', 'collection-seller')
                ->references('id')->on('users')
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
