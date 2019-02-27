<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use Auth;
use Validator;
use App\Media;
use App\Folder;
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
    	try {
            $medias = Media::orderBy('id', 'desc')->paginate(24);
            $folder = Folder::find(1);
            $folder_list = Folder::where('folder_id',$folder->id)->get();
            $new = ['folder_id' => $folder->id,'folder_name' => $folder->name, 'folder_slug'=>$folder->slug];
            $folder_string[] = $new;
            $slider = Slider::find($id);
            return view('admin.sliders.edit', [
                'slider'                => $slider,
                'medias'                => $medias,
                'folder'                => $folder,
                'folder_list'           => $folder_list,
                'folder_string'         => $folder_string,
            ]);
        } catch (\Exception $e) {
    	    return $e->getMessage();
        }
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
	                Image::make($file)->resize(1900, null, function ($constraint) {
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
    	try {
            $medias_id = $request->get('media_id','');
            if(!empty($medias_id))
            {
                foreach($medias_id as $media_id)
                {
                    $sliderDetail = new SliderDetail;
                    $sliderDetail->slider_id = $id;
                    $sliderDetail->media_id = $media_id;
                    $sliderDetail->save();
                }
            } else {
                return redirect()->back()->with('error', 'Không có image nào được chọn');
            }
            return redirect()->back()->with('status','Cập nhật hình ảnh thành công');
        } catch(\Exception $e) {
    	    return redirect()->back()->with('error',$e->getMessage());
        }
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

    public function ajaxUpload(Request $request)
    {
        try {
            if($request->ajax())
            {
                $slider     = Slider::find($request->get('slider_id'));
                $files      = $request->file('medias');
                $folder     = Folder::find($request->folder_id);
                $folder_id  = $folder->id;

                if($files === null)
                {
                    return response()->json([
                        'error'   => '1',
                        'message' => 'File is empty',
                    ]);
                }
                foreach ($files as $file)
                {
                    $file = Media::ajaxUploadImage($file, $folder_id);
                    if(empty($file))
                    {
                        return response()->json([
                            'error'   => '1',
                            'message' => 'Upload failed!',
                        ]);
                    }
                }

                if(!empty($files))
                {
                    $medias = Media::where('folder_id', '=', $folder_id)->orderBy('id', 'desc')->get();
                    $folder_list = Folder::where('folder_id',$folder_id)->get();
                    $data   = view('admin.ajax.media.slider.new_files', compact('medias', 'folder', 'folder_list', 'slider'))->render();
                    return response()->json([
                        'data'        => $data,
                        'file'        => $files,
                        'success'     => '1',
                        'message'     => 'Success'
                    ]);
                }
                else
                {
                    return response()->json([
                        'error'   => '1',
                        'message' => 'File must be a image type',
                    ]);
                }
            }
        } catch (\Exception $e) {
            return response()->json([
                'error'   => '1',
                'message' => $e->getMessage(),
            ]);
        }
    }

}
