<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class Product extends Model
{
	use HasFactory;
	const PathToStoredImages = 'product/images/covers';
	protected $fillable = [
		'name',
		'description',
		'price',
		'cover',
		'stock_status',
		'offer_enabled',
		'offer_content',
		'category_id'
	];
	protected $casts = [
		'price' => 'double',
	];


	public function getPriceAfterOfferAttribute()
	{
		if ($this->offer_enabled) {
			$discount = $this->price * ($this->offer_content / 100);
			return $this->price - $discount;
		}
		return $this->price;
	}



	public function category()
	{
		return $this->belongsTo(Category::class);
	}

	public function productImages()
	{
		return $this->hasMany(ProductImage::class);
	}
}
