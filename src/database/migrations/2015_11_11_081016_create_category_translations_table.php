<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCategoryTranslationsTable extends Migration {

	public function up()
	{
		Schema::create('category_translations', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('category_id')->unsigned();
			$table->string('locale', 2);
			$table->string('name')->nullable();
			$table->string('description');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('category_translations');
	}
}