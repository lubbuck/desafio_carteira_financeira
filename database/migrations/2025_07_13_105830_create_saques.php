<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('saques', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('valor');
            $table->string('status');
            $table->uuid('carteira_id');
            $table->foreign('carteira_id')->references('id')->on('carteiras');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('saques');
    }
};
