<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('operationdetailes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('operation_id');
            $table->foreign('operation_id')->references('id')->on('operations')->onDelete('cascade');
            $table->float('thickness')->nullable();
            $table->float('length')->nullable();
            $table->float('width')->nullable();
            $table->float('weight')->nullable();
            $table->integer('passes')->nullable();
            $table->integer('cuttingqnty')->nullable();
            $table->integer('quantity')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
