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
        Schema::table('lg_catalog_product_index', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('id_product');

            $table->timestamps();
        });

        Schema::table('lg_catalog_category_index', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('id_category');

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
        Schema::drop('lg_catalog_product_index');
        Schema::drop('lg_catalog_category_index');
    }
}
