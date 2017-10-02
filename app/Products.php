<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    //
	private $lang;

    public function __construct($parameters)
    {
        $this->lang = isset($parameters['lang']) ? $parameters['lang'] : 'en';
    }

    public function ProductsDescriptions()
    {
    	return $this->hasMany('App\ProductsDescriptions', 'productid', 'productid')->where('lang', $this->lang);
    }
}
