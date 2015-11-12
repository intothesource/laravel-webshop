<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Eloquent\Model;

class CreateForeignKeys extends Migration {

	public function up()
	{
		Schema::table('products', function(Blueprint $table) {
			$table->foreign('tax_id')->references('id')->on('taxes')
						->onDelete('restrict')
						->onUpdate('cascade');
		});

		Schema::table('product_translations', function(Blueprint $table) {
			$table->foreign('product_id')->references('id')->on('products')
						->onDelete('cascade')
						->onUpdate('cascade');
			$table->foreign('locale')->references('locale')->on('languages')
						->onDelete('restrict')
						->onUpdate('cascade');
		});

		Schema::table('product_variants', function(Blueprint $table) {
			$table->foreign('product_id')->references('id')->on('products')
						->onDelete('cascade')
						->onUpdate('cascade');
		});

		Schema::table('product_variant_translations', function(Blueprint $table) {
			$table->foreign('variant_id')->references('id')->on('product_variants')
						->onDelete('cascade')
						->onUpdate('cascade');
			$table->foreign('locale')->references('locale')->on('languages')
						->onDelete('restrict')
						->onUpdate('cascade');
		});

		Schema::table('product_categories', function(Blueprint $table) {
			$table->foreign('product_id')->references('id')->on('products')
						->onDelete('restrict')
						->onUpdate('cascade');
		});

		Schema::table('product_categories', function(Blueprint $table) {
			$table->foreign('category_id')->references('id')->on('categories')
						->onDelete('restrict')
						->onUpdate('cascade');
		});

		Schema::table('category_translations', function(Blueprint $table) {
			$table->foreign('category_id')->references('id')->on('categories')
						->onDelete('cascade')
						->onUpdate('cascade');
			$table->foreign('locale')->references('locale')->on('languages')
						->onDelete('restrict')
						->onUpdate('cascade');
		});
	}

	public function down()
	{
		Schema::table('products', function(Blueprint $table) {
			$table->dropForeign('products_tax_id_foreign');
		});
		Schema::table('product_translations', function(Blueprint $table) {
			$table->dropForeign('product_translations_product_id_foreign');
		});
		Schema::table('product_variants', function(Blueprint $table) {
			$table->dropForeign('product_variants_product_id_foreign');
		});
		Schema::table('product_variant_translations', function(Blueprint $table) {
			$table->dropForeign('product_variant_translations_variant_id_foreign');
		});
		Schema::table('product_categories', function(Blueprint $table) {
			$table->dropForeign('product_categories_product_id_foreign');
		});
		Schema::table('product_categories', function(Blueprint $table) {
			$table->dropForeign('product_categories_category_id_foreign');
		});
		Schema::table('category_translations', function(Blueprint $table) {
			$table->dropForeign('category_translations_category_id_foreign');
		});
	}
}