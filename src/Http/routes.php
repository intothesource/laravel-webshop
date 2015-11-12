<?php 

Route::group(['prefix' => config('webshop.prefix')], function() {

	// Productbeheer
	Route::resource('product', 	'ProductController');
	Route::resource('variant', 	'ProductVariantController', ['only' => ['store', 'destroy']]);
	Route::patch('variant/{variant}/toggle', ['as' => 'variant.toggle',	'uses' => 'ProductVariantController@toggle']);

	// Catergoriebeheer
	Route::resource('category', 	'CategoryController');

});
