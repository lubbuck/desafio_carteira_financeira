<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('entradas', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->text('tipo_operacao');
            $table->integer('valor');
            $table->string('status');
            $table->uuid('operacao_id');
            $table->uuid('carteira_id');
            $table->foreign('carteira_id')->references('id')->on('carteiras');
            $table->timestamps();
        });

        Schema::create('saidas', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->text('tipo_operacao');
            $table->integer('valor');
            $table->string('status');
            $table->uuid('operacao_id');
            $table->uuid('carteira_id');
            $table->foreign('carteira_id')->references('id')->on('carteiras');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('entradas');
        Schema::dropIfExists('saidas');
    }
};
