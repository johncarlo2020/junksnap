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
        Schema::table('collections', function (Blueprint $table) {
            $table->unsignedBigInteger('status_id')->default(1);
            $table->timestamps();

            $table->index(["status_id"], 'collection-status');

            $table->foreign('status_id', 'collection-status')
            ->references('id')->on('status')
            ->onDelete('restrict')
            ->onUpdate('restrict');
            //
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('collections', function (Blueprint $table) {
            //
        });
    }
};
