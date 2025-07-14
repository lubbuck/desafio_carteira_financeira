<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('carteiras', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('codigo')->unique();
            $table->integer('saldo')->default(0);
            $table->boolean('ativada')->default(true);
            $table->uuid('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('carteiras');
    }
};
