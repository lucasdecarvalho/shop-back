<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sellers', function (Blueprint $table) {
            $table->id();
            $table->string('fantasia')->nullable();
            $table->string('nome')->nullable();
            $table->string('abertura')->nullable();
            $table->string('cnpj')->unique();

            $table->string('logradouro')->nullable();
            $table->string('numero')->nullable();
            $table->string('complemento')->nullable();
            $table->string('bairro')->nullable();
            $table->string('municipio')->nullable();
            $table->string('uf')->nullable();
            $table->string('cep')->nullable();

            $table->string('status')->nullable();
            $table->string('situacao')->nullable();
            $table->string('porte')->nullable();
            $table->string('capital_social')->nullable();

            $table->string('telefone')->nullable();
            $table->string('telefone2')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('alias')->nullable();

            $table->string('firstName')->nullable();
            $table->string('lastName')->nullable();
            $table->string('cpf')->nullable();
            $table->string('cel')->nullable();

            $table->string('bankName')->nullable();
            $table->string('bankType')->nullable();
            $table->string('bankAg')->nullable();
            $table->string('bankAccount')->nullable();
            
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
        Schema::dropIfExists('sellers');
    }
}
