<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductVariantsTable extends Migration {

	public function up()
	{
		Schema::create('product_variants', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('product_id')->unsigned();
			$table->decimal('price', 10,2);
			$table->string('image')->nullable();
			$table->tinyInteger('active')->default('0');
			$table->timestamps();
			$table->softDeletes();
		});
	}

	public function down()
	{
		Schema::drop('product_variants');
	}
}