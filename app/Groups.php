<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Groups extends Model
{
    //
	private $lang;

    public function __construct($parameters)
    {
    	$this->lang = isset($parameters['lang']) ? $parameters['lang'] : 'en';
    }

    public function GroupsDescriptions()
    {
    	return $this->hasMany('App\GroupsDescriptions', 'groupid', 'groupid')->where('lang', $this->lang);
    }

    public function AllGroupsDescriptions()
    {
        return $this->hasMany('App\GroupsDescriptions', 'groupid', 'groupid')->orderBy('lang');        
    }
}
