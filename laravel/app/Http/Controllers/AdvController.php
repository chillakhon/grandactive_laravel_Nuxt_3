<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestAdv;
use App\Models\Adv;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use function Psy\debug;

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


    public function getAds(){
        $user_id = Auth::user()->id;
        $ads = Adv::where('user_id', $user_id)
            ->with('images','category','sub_category','section','city')
            ->get();
        return response()->json($ads);
    }

    public function delete(Request $request){

        $ad = Adv::find($request->id);
        $ad->delete();
        if ($request->images){
            foreach ($request->images as $image){
                $path = 'public/images/' . $image['image_path'];
                Storage::delete($path);
            }
        }
        $user_id = Auth::user()->id;
        $ads = Adv::where('user_id', $user_id)
            ->with('images','category','sub_category','section','city')
            ->get();
        return response()->json($ads);
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
