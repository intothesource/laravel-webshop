<?php

namespace Intothesource\Webshop;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model {

	use \Dimsav\Translatable\Translatable;
	public $translatedAttributes 	= ['sku','name','description'];
	
	protected $table = 'products';
	public $timestamps = true;

	use SoftDeletes;

	protected $dates = ['deleted_at'];

	public function tax()
	{
		return $this->belongsTo('Tax');
	}

	public function product_translations()
	{
		return $this->hasMany('Product_translation', 'product_id');
	}

	public function product_variants()
	{
		return $this->hasMany('Product_variant', 'product_id');
	}

	public function product_categories()
	{
		return $this->hasMany('Product_category', 'product_id');
	}

}