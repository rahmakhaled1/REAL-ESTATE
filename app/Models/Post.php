<?php

namespace App\Models;

use App\Traits\SearchTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory, SearchTrait;

    protected $fillable = [
        'title',
        'description',
        'location',
        'price',
        'city',
        'rooms',
        'kitchens',
        'bedrooms',
        'bathrooms',
        'category',
        'user_id',
        'post_id'
    ];

    protected $searchable = ['rooms', 'kitchens', 'bedrooms', 'bathrooms', 'category', 'price'];

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function imageLink() : Attribute
    {
        return Attribute::make(
            get: fn () => $this->image ? url("uploads/"."$this->image") : '',
        );
    }

}
