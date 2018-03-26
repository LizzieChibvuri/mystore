<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Product extends Model
{
    //fillable fields
    protected $fillable=['name','price','category','stocklevel','discount','product_image'];

    //adding a relationship to user
   /* public function orders()
    {
    	return $this->hasMany('App\Order');

    }*/
}
