<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTaxesTable extends Migration {

	public function up()
	{
		Schema::create('taxes', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->decimal('rate', 4,2);
		});
	}

	public function down()
	{
		Schema::drop('taxes');
	}
}