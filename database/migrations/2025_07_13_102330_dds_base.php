<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // se o banco n for postgres comentar a linha abaixo
        DB::statement('CREATE EXTENSION IF NOT EXISTS unaccent;');

        Schema::create('auditorias', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('user_type')->nullable();
            $table->string('event');
            $table->string('table_name');
            $table->string('table_id');
            $table->json('new_values');
            $table->text('url');
            $table->ipAddress('ip_address');
            $table->text('user_agent');
            $table->uuid('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });

        Schema::create('auditorias_acessos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('event');
            $table->text('url');
            $table->ipAddress('ip_address');
            $table->text('user_agent');
            $table->uuid('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });

        // inicio esquema de gestão de permissões
        Schema::create('permissions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nome')->unique();
            $table->string('group');
            $table->boolean('is_open')->default(false);
            $table->string('sub_group')->nullable();
            $table->string('descricao')->nullable();
            $table->timestamps();
        });

        Schema::create('permissions_rotas', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('route_name')->unique();
            $table->uuid('permission_id');
            $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('users_permissions', function (Blueprint $table) {
            $table->uuid('user_id');
            $table->uuid('permission_id');
            $table->primary(['user_id', 'permission_id']);

            $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
        // fim esquema de gestão de permissões
    }

    public function down()
    {
        // se o banco n for postgres comentar a linha abaixo
        DB::statement('DROP EXTENSION IF EXISTS unaccent;');

        Schema::dropIfExists('auditorias');
        Schema::dropIfExists('auditorias_acessos');
        Schema::dropIfExists('users_permissions');
        Schema::dropIfExists('permissions_rotas');
        Schema::dropIfExists('permissions');
    }
};
