<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('depositos', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('valor');
            $table->string('status');
            $table->uuid('carteira_id');
            $table->foreign('carteira_id')->references('id')->on('carteiras');
            $table->timestamps();
        });

        Schema::create('depositos_reversao', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('valor');
            $table->string('status');
            $table->uuid('deposito_id');
            $table->foreign('deposito_id')->references('id')->on('depositos');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('depositos_reversao');
        Schema::dropIfExists('depositos');
    }
};
