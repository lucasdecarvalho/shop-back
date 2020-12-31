<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellerAccessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seller_accesses', function (Blueprint $table) {
            $table->id();
            $table->string('id_user');
            $table->longtext('access_token');
            $table->string('m_name')->nullable();
            $table->string('os')->nullable();
            $table->string('ip')->nullable();
            $table->string('typeAccount');
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
        Schema::dropIfExists('seller_accesses');
    }
}
