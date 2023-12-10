<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public $tableName = 'user_documents';

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

            $table->unsignedBigInteger('user_id')->nullable();
        
            $table->index(["user_id"], 'documents-user');
        
            $table->foreign('user_id', 'documents-user')
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
