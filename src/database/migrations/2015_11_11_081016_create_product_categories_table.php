<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductCategoriesTable extends Migration {

	public function up()
	{
		Schema::create('product_categories', function(Blueprint $table) {
			$table->integer('product_id')->primary()->unsigned();
			$table->integer('category_id')->primary()->unsigned();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('product_categories');
	}
}