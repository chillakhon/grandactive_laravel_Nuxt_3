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
    public function index(Request $request){
        $ads = Adv::with('images','category','sub_category','section','city');

        if($request->has('section_id')){
            $ads = $ads->where('section_id',$request->section_id);
        }
        if($request->has('category_id')){
            $ads = $ads->where('category_id',$request->category_id);
        }

        if($request->has('sub_category_id')){
            $ads = $ads->where('sub_category_id',$request->sub_category_id);
        }

        return response()->json($ads->get());
    }

    public function getAd(Request $request) {
        $ad = Adv::with('images','category','sub_category','section','city','user')->find($request->id);
        $views = $ad->where('id',$request->id)->get('views');
        $views = $views[0]->views + 1;
        $ad->where('id',$request->id)->update(['views' => $views]);
        return response()->json($ad);
    }

    public function popular () {
        $ads = Adv::with('images','category','sub_category','section','city')->orderBy('views','desc')->take(15)->get();
        return response()->json($ads);
    }

    public function newAds() {
        $ads = Adv::with('images','category','sub_category','section','city')->orderBy('created_at','desc')->take(15)->get();
        return response()->json($ads);
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


    public function update(Request $request, $id)
    {
        $ad = Adv::find($id);
        $imageTable = $ad->images;
        $imagePaths = $imageTable->pluck('image_path')->toArray();

        $imageCurrent = array_column( json_decode($request->imagesCurrent, true),'image_path');

        $toDelete = array_diff($imagePaths, $imageCurrent);
            foreach ($toDelete as $path) {
                Storage::delete('public/images/' . $path);
                $imageToDelete = $imageTable->where('image_path', $path)->first();
                if ($imageToDelete) {
                    $imageToDelete->delete();
                }
            }
            $this->uploadImage($request,$ad);

            $adToUpdate = json_decode($request->ad,true);
            $ad->update($adToUpdate);

        $user_id = Auth::user()->id;
        $ads = Adv::where('user_id', $user_id)
            ->with('images','category','sub_category','section','city')
            ->get();
            return response()->json($ads);
    }
















    private function uploadImage($request, $adv): void
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
