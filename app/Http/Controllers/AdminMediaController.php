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
    	try {
            $medias = Media::where('folder_id',1)->orderBy('id', 'desc')->paginate(24);
            $folder = Folder::find(1);
            $folder_list = Folder::where('folder_id',$folder->id)->get();
            $new = ['folder_id' => $folder->id,'folder_name' => $folder->name, 'folder_slug'=>$folder->slug];
            $folder_string[] = $new;
            return view('admin.media.index', compact('medias','folder','folder_list','folder_string'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function create(Request $request)
    {
        try {
            $files     = $request->file('medias');
            $folder    = Folder::find($request->folder_id);
            $folder_id = $folder->id;

            if($files === null)
            {
                return redirect()->route('admin.media.index')->with('error','No input');
            }
            $path = '';
            if($folder_id == 1) {
//                $path = public_path('images/' . $name);
                $path  = 'images';
            } else {
                $folder_temp_id = $folder_id;
                while($folder_temp_id != 1)
                {
                    $folder_temp = Folder::findOrFail($folder_temp_id);
                    $folder_temp_id = $folder_temp->folder->id;
                    $path_arr[] = $folder_temp->slug;
                }
                $path .= 'images/';
                for($i = count($path_arr)-1; $i >= 0; $i--)
                {
                    if($i == 0){
                        $path .= $path_arr[$i];
                    } else {
                        $path .= $path_arr[$i] . '/';
                    }
                }
            }

            foreach($files as $file)
            {
                $file->getClientMimeType();

                if(substr($file->getMimeType(), 0, 5) == 'image') {
                    $name = time() . '_media_' . $file->getClientOriginalName();
                    $type = $file->getMimeType();
                    $path_file = public_path($path . '/' . $name);
                    Image::make($file)->resize(1000, null, function ($constraint) {
                        $constraint->aspectRatio();})->save($path_file);
                    $admin_id = Auth::user()->id;
                    $media = Media::create([
                        'file_name'  =>  $name,
                        'url'        =>  $path . '/' . $name,
                        'type'       =>  $type,
                        'admin_id'   =>  $admin_id,
                        'folder_id'  =>  $folder_id,
                    ]);
                } else {
                    if($folder_id == 1) {
                        return redirect()->route('admin.media.index')
                            ->with('error','Not a image file!');
                    } else {
                        return redirect()->route('admin.folder.show', ['id'=>$folder->id,'slug'=>$folder->slug])
                            ->with('error','Not a image file!');
                    }
                }

            }
            if($folder_id == 1) {
                return redirect()->route('admin.media.index')
                    ->with('status','Upload successfully!');
            } else {
                return redirect()->route('admin.folder.show', ['id'=>$folder->id,'slug'=>$folder->slug])
                    ->with('status','Upload successfully!');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('status',$e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
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

    public function destroy(Request $request, $id)
    {
        $media     = Media::findOrFail($id);
        $folder    = Folder::find($request->folder_id);
        $folder_id = $folder->id;
        if($folder->id > 1) {
            $folder_temp_id = $folder_id;
            $path = '';
            while($folder_temp_id != 1)
            {
                $folder_temp = Folder::findOrFail($folder_temp_id);
                $folder_temp_id = $folder_temp->folder->id;
                $path_arr[] = $folder_temp->slug;
            }
            $path .= 'images/';
            for($i = count($path_arr)-1; $i >= 0; $i--)
            {
                if($i == 0){
                    $path .= $path_arr[$i];
                } else {
                    $path .= $path_arr[$i] . '/';
                }
            }
            $url = $path . '/' . $media->file_name;
            unlink(public_path() . '/'. $url);
        } else {
            unlink(public_path() . '/images/' . $media->file_name);
        }
        $media->delete();
        if($folder->id > 1) {
            return redirect()->route('admin.folder.show', ['id'=>$folder->id,'slug'=>$folder->slug])->with('delete', 'Delete successfully!');
        }
        return redirect()->route('admin.media.index')->with('delete','Delete successfully!');
    }
}
