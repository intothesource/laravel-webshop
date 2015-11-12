<?php

namespace Intothesource\Webshop;

use Illuminate\Database\Eloquent\Model;

class Tax extends Model {

	protected $table = 'taxes';
	public $timestamps = false;

	public function products()
	{
		return $this->hasMany('Product', 'tax_id');
	}

}