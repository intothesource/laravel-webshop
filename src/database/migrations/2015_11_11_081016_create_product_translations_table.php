<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductTranslationsTable extends Migration {

	public function up()
	{
		Schema::create('product_translations', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('product_id')->unsigned();
			$table->string('locale', 2);
			$table->string('sku')->nullable();
			$table->string('name')->nullable();
			$table->string('description')->nullable();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('product_translations');
	}
}