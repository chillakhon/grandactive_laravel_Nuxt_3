<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function index(){
        $images = \App\Models\Image::all();
        return response()->json($images);
    }

    public function getImagePath($url = null)
    {
        $path = storage_path('app/public/images/') . $url;
        if (!File::exists($path)) {
            $path = storage_path('app/public/images/img_default.png');
            return response()->file($path);
        }
        return response()->file($path);
    }

}
