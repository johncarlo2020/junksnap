<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public $tableName = 'applications';

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
            $table->unsignedBigInteger('status_id');
            $table->unsignedBigInteger('user_id');
            $table->string('comment')->nullable();


            $table->timestamps();

            $table->index(["status_id"], 'application-status');
            $table->index(["user_id"], 'application-user');


            $table->foreign('status_id', 'application-status')
            ->references('id')->on('application_status')
            ->onDelete('restrict')
            ->onUpdate('restrict');

            $table->foreign('user_id', 'application-user')
            ->references('id')->on('users')
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
