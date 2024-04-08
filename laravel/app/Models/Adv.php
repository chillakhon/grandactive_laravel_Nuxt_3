<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adv extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'type',
        'category_id',
        'user_id',
        'city_id',
        'investment_sum_min',
        'investment_sum_max',
        'investment_size',
        'section_id',
        'sub_category_id',
        ];
    public function images(){
        return $this->hasMany(AdvImage::class);
    }
    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function sub_category(){
        return $this->belongsTo(SubCategory::class);
    }
    public function section(){
        return $this->belongsTo(Section::class);
    }
    public function city(){
        return $this->belongsTo(City::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
