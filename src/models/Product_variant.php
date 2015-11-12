<?php

namespace Intothesource\Webshop;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product_variant extends Model {

	use \IntoTheSource\Translatable\Translatable;
	public $translatedAttributes 	= ['sku','name','description'];
	
	protected $table = 'product_variants';
	public $timestamps = true;

	use SoftDeletes;

	protected $dates = ['deleted_at'];

	public function product()
	{
		return $this->belongsTo('Product');
	}

	public function product_variant_translations()
	{
		return $this->hasMany('Product_variant_translation', 'variant_id');
	}

}