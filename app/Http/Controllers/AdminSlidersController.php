<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use Auth;
use Validator;
use App\Media;
use App\Slider;
use App\SliderDetail;

class AdminSlidersController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
    	$sliders = Slider::all();
    	return view('admin.sliders.index', compact('sliders'));
    }

    public function edit($id)
    {
    	$medias = Media::orderBy('id', 'desc')->paginate(24);
    	$slider = Slider::findOrFail($id);
    	//dd($slider->sliderDetails->media->id);
    	return view('admin.sliders.edit', compact('slider','medias'));
    }

    public function upload(Request $request, $id)
    {
    	$files = $request->file('medias');
    	$slider = Slider::findOrFail($id);
    	if($files === null)
    	{
    		return redirect()->route('admin.sliders.edit', [$id])->with('error','No input');
    	}
    	else
    	{
    		foreach($files as $file)
	    	{
	    		$file->getClientMimeType();
	    		//echo $file->getMimeType();
	    		if(substr($file->getMimeType(), 0, 5) == 'image') {
				    $name = time() . '_media_' . $file->getClientOriginalName();
				    $path = 'images/'.$name;
				    $type = $file->getMimeType();
		            //$file->move('images', $name);
	                Image::make($file)->resize(1400, null, function ($constraint) {
	                    $constraint->aspectRatio();})->save($path);
		            $admin_id = Auth::user()->id;
		            $media = Media::create(['file_name'=>$name, 'url'=>$path, 'type'=>$type, 'admin_id'=>$admin_id]);
				}
				else
				{
					return redirect()->route('admin.media.index')->with('error','Not a image file!');
				}
				if($media->id > 0)
                {
                    $sliderDetail = new SliderDetail;
                    $sliderDetail->slider_id = $id;
                    $sliderDetail->media_id = $media->id;
                    $sliderDetail->save();
                }
	    	}
    	}
    	return redirect()->back()->with('status','Upload hình ảnh thành công');
    }

    public function selectImage(Request $request, $id)
    {
    	//dd($request->all());
    	$input = $request->all();
    	if($input['media_id'])
        {
        	foreach($input['media_id'] as $input_media)
            {
            	$sliderDetail = new SliderDetail;
		        $sliderDetail->slider_id = $id;
		        $sliderDetail->media_id = $input_media;
		        $sliderDetail->save();
            }
        }
        return redirect()->back()->with('status','Cập nhật hình ảnh thành công');
    }

    public function updateLink(Request $request, $slider_id, $id)
    {
    	$validator = Validator::make($request->all(), [
            'link' => 'nullable|string|max:255'
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.sliders.edit', [$slider_id])
                        ->withErrors($validator)
                        ->withInput();
        }
    	$sliderDetail = SliderDetail::findOrFail($id);
    	$sliderDetail->link = $request->link;
    	$sliderDetail->save();
    	return redirect()->route('admin.sliders.edit', [$slider_id])->with('status','Cập nhật link thành công');
    }


    public function destroyImage($slider_id, $id)
    {
    	$sliderDetail = SliderDetail::findOrFail($id);
    	$sliderDetail->delete();
    	return redirect()->route('admin.sliders.edit', [$slider_id])->with('status','Xóa hình ảnh thành công');
    }

}
