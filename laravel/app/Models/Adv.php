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
}
