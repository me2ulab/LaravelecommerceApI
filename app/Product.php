<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Category;
use App\Seller;
use App\Transaction;
class Product extends Model
{
    //
    const AVAILABLE_PRODUCT='available';
    const UNAVAILABLE_PRODUCT='unavailable';
    protected $fillable=[
    	'name',
    	'description',
    	'quantity',
    	'status',
    	'image',
    	'seller_id'
    ];
    public function isAvailable()
    {
    	return $this->status==Product::AVAILABLE_PRODUCT;
    }
    public function categories()
    {
    	return $this->belongsToMany('App\Category');
    }
    public function seller()
    {
    	return $this->belongsTo(Seller::class);
    }
    public function transactions()
    {
    	return $this->hasMany(Transaction::class);
    }
}
