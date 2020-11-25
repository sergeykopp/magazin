<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->string('name');
            $table->string('artikul')->unique();
            $table->text('description')->nullable();
            $table->integer('price')->unsighed()->default(0);
            $table->integer('discount')->unsighed()->default(0);
            $table->integer('category_id')->unsighed();
            $table->integer('brand_id')->unsighed();
            $table->boolean('actual')->default(true);
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
