<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductCategoryIndexTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lg_catalog_product_index', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('product_id');
            $table->unsignedInteger('store_id');

            $table->timestamps();

            $table->foreign('product_id')->references('entity_id')->on('catalog_product_entity');
            $table->foreign('store_id')->references('store_id')->on('store');
        });

        Schema::create('lg_catalog_category_index', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('category_id');
            $table->unsignedInteger('store_id');

            $table->timestamps();

            $table->foreign('category_id')->references('entity_id')->on('catalog_category_product');
            $table->foreign('store_id')->references('store_id')->on('store');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('lg_catalog_product_index');
        Schema::drop('lg_catalog_category_index');
    }
}
