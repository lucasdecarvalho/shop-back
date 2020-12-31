<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->integer('store');
            $table->string('name');
            $table->string('caption')->nullable();
            $table->string('brand')->nullable();
            $table->integer('storage_initial');
            $table->integer('storage_current')->nullable();
            $table->boolean('available')->default(true);
            $table->longText('description')->nullable();
            $table->longText('details')->nullable();
            $table->decimal('price', 8,2);
            $table->integer('discount')->nullable();
            $table->longText('photo1')->nullable();
            $table->longText('photo2')->nullable();
            $table->longText('photo3')->nullable();
            $table->longText('photo4')->nullable();
            $table->longText('photo5')->nullable();
            $table->longText('photo6')->nullable();
            $table->longText('video')->nullable();
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
        Schema::dropIfExists('products');
    }
}
