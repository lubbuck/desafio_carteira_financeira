<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('transferencias', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('valor');
            $table->string('status');
            $table->uuid('carteira_origem_id');
            $table->uuid('carteira_destino_id');
            $table->foreign('carteira_origem_id')->references('id')->on('carteiras');
            $table->foreign('carteira_destino_id')->references('id')->on('carteiras');
            $table->timestamps();
        });

        Schema::create('solicitacoes_transferencias_reversao', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->text('motivo');
            $table->uuid('transferencia_id');
            $table->foreign('transferencia_id')->references('id')->on('transferencias');
            $table->timestamps();
        });

        Schema::create('transferencias_reversao', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('valor');
            $table->string('status');
            $table->uuid('transferencia_id');
            $table->foreign('transferencia_id')->references('id')->on('transferencias');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transferencias_reversao');
        Schema::dropIfExists('solicitacoes_transferencias_reversao');
        Schema::dropIfExists('transferencias');
    }
};
