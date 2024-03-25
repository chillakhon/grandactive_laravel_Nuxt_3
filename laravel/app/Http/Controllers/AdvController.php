<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestAdv;
use App\Models\Adv;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class AdvController extends Controller
{
    public function index(){
        return 'nu';
    }

    public function store(RequestAdv $request){
        $user_id = Auth::user()->id;
        $ad = json_decode($request->ad, true);
        $ad['user_id'] = $user_id;
        $ad = Adv::create($ad);

        $this->uploadImage($request, $ad);

        return response()->json($ad);
    }

    /**
     * @param RequestAdv $request
     * @param $adv
     * @return void
     */
    public function uploadImage(RequestAdv $request, $adv): void
    {
        if ($request->hasFile('images')) {
            $manager = new ImageManager(new Driver());
            foreach ($request->file('images') as $image) {
                $random = rand(1000000, 99999999) . '_' . $adv->id;
                $imageName = $random . '.' . $image->getClientOriginalExtension();
                $img = $manager->read($image);
                $img = $img->resize(370, 246);
                $path = 'public/images/' . $imageName;
                Storage::put($path, $img->encode());
                $adv->images()->create([
                    'image_path' => $imageName,
                ]);
            }
        }
    }
}
