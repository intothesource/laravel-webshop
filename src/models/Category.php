<?php

namespace Intothesource\Webshop;

use Illuminate\Database\Eloquent\Model;

class Category extends Model {

	use \IntoTheSource\Translatable\Translatable;
	public $translatedAttributes 	= ['name','description'];
	
	protected $table = 'categories';
	public $timestamps = true;

	public function products()
	{
		return $this->hasMany('Product_category', 'category_id');
	}

	public function category_translations()
	{
		return $this->hasMany('Category_translation', 'category_id');
	}

}