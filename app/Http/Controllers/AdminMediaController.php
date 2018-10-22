<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use Auth;
use Validator;
use App\Media;
use App\Folder;
use App\Alpha;

class AdminMediaController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
    	$medias = Media::where('folder_id',1)->orderBy('id', 'desc')->paginate(24);
        $folder = Folder::findOrFail(1);
        $folder_list = Folder::where('folder_id',$folder->id)->get();
        $media = Media::findOrFail(22);
        $width = Image::make($media->url)->width();
        $new = ['folder_name' => $folder->name, 'folder_slug'=>$folder->slug];
        $folder_string[] = $new;
    	return view('admin.media.index', compact('medias','folder','folder_list','folder_string'));
    }

    public function create(Request $request)
    {
    	
    	$files = $request->file('medias');

    	if($files === null)
    	{
    		return redirect()->route('admin.media.index')->with('error','No input');
    	}

    	foreach($files as $file)
    	{
    		$file->getClientMimeType();
    		if(substr($file->getMimeType(), 0, 5) == 'image') {
			    $name = time() . '_media_' . $file->getClientOriginalName();
			    $type = $file->getMimeType();
                Image::make($file)->resize(1000, null, function ($constraint) {
                    $constraint->aspectRatio();})->save('images/'.$name);
	            $admin_id = Auth::user()->id;
	            $media = Media::create(['file_name'=>$name, 'url'=>$name, 'type'=>$type, 'admin_id'=>$admin_id, 'folder_id'=>$request->folder_id]);
			}
			else
			{
				return redirect()->route('admin.media.index')->with('error','Not a image file!');
			}
    	}
    	return redirect()->route('admin.media.index')->with('status','Upload successfully!');
    }

    public function update(Request $request, $id)
    {
    	//dd($request->all());
        $media = Media::findOrFail($id);
        if($request->title == '')
        {
            if($request->caption == '')
            {
                if($request->alt_text == '')
                {
                    if($request->description == '')
                    {
                        return redirect()->route('admin.media.index')->with('status','Update successfully!');
                    }
                    else { $media->description = $request->description; }
                }
                else { $media->alt_text = $request->alt_text; }
            }
            else { $media->caption = $request->caption; }
        }
        else { $media->title = $request->title; }
        $media->save();
        return redirect()->route('admin.media.index')->with('status','Update successfully!');
    }

    public function destroy($id)
    {
        $media = Media::findOrFail($id);
        unlink(public_path() . '/images/' . $media->file_name);
        $media->delete();
        return redirect()->route('admin.media.index')->with('delete','Delete successfully!');
    }
}
