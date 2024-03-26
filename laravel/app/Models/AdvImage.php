<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdvImage extends Model
{
    use HasFactory;
    protected $fillable = [
        'adv_id',
        'image_path',
    ];
    public function adv(){
        return $this->belongsTo(Adv::class);
    }
}
