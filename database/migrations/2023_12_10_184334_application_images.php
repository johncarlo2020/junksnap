<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public $tableName = 'application_images';

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
            $table->string('image');
            $table->unsignedBigInteger('application_id');
            $table->timestamps();

            $table->index(["application_id"], 'application-images');

            $table->foreign('application_id', 'application-images')
            ->references('id')->on('applications')
            ->onDelete('restrict')
            ->onUpdate('restrict');

            //

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
