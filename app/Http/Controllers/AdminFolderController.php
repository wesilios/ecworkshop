<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Auth;
use Validator;
use App\Folder;
use App\Alpha;
use App\Media;

class AdminFolderController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function create(Request $request)
    {
    	if($request->ajax()) {
    	    $validator = Validator::make($request->all(), [
                'folder_name' => 'required|string|max:255'
            ]);
            if($validator->fails())
            {
                $mess = '<span id="helpBlock2" class="help-block">Folder name is empty.</span>';
                $mess->render();
                return response()->json(['error'=>'1', 'mess'=> $mess]);
            }

            $folder_id_parent = $request->folder_id;
            $path = preg_replace("/\\\\/", '/',public_path());
            $origin = Alpha::alpha_dash($request->folder_name);
            $findFolder = Folder::where('origin','LIKE', $origin.'%')
                ->where('folder_id','=',$folder_id_parent)->get();
            if($findFolder->isNotEmpty()) {
                $count          = count($findFolder)+1;
                $slug           = $origin . '_' . $count;
                $folder_name    = $request->folder_name . '_' .$count;
            } else {
                $slug           = $origin;
                $folder_name    = $request->folder_name;
            }

            if($request->folder_id == 1) {
                $path .= '/images/' . $slug ;
            }
            else
            {
                while($folder_id_parent != 1)
                {
                    $folder_temp = Folder::findOrFail($folder_id_parent);
                    $folder_id_parent = $folder_temp->folder->id;
                    $path_arr[] = $folder_temp->slug;
                }
                $path .= '/images/';
                for($i = count($path_arr)-1; $i >= 0; $i--)
                {
                    $path .= $path_arr[$i] . '/';
                }
                $path .= $slug;
            }
            if(!file_exists($path)) {
                mkdir($path, 0777, true);
                chmod($path, 0777);
            }
            $folder = new Folder;
            $folder->name = $folder_name;
            $folder->slug = $slug;
            $folder->origin = $origin;
            $folder->folder_id = $request->folder_id;
            $folder->save();
            $folder = Folder::findOrFail($request->folder_id);
            $folder_list = Folder::where('folder_id',$request->folder_id)->get();
            $data = view('admin.ajax.folder.index',compact('folder','folder_list'))->render();
            return response()->json(['option'=>$data]);
        }
    }

    public function show($slug)
    {
    	$folder = Folder::where('slug',$slug)->first();
        $folder_list = Folder::where('folder_id', $folder->id)->get();
        $medias = Media::where('folder_id',$folder->id)->orderBy('id', 'desc')->paginate(24);
    	$folder_id_parent = $folder->folder->id;
    	$folder_string = [['folder_name'=>'root','folder_slug'=>'root']];

    	while($folder_id_parent != 1)
    	{
    		$folder_temp = Folder::findOrFail($folder_id_parent);
    		$folder_id_parent = $folder_temp->folder->id;
    		$new = ['folder_name' => $folder_temp->name, 'folder_slug'=>$folder_temp->slug];
    		$folder_string[] = $new;
    	}

    	$new = ['folder_name' => $folder->name, 'folder_slug'=>$folder->slug];
        $folder_string[] = $new;

    	//echo '<pre>', print_r($folder_string), '</pre>';
        return view('admin.media.index', compact('medias','folder','folder_list','folder_string'));
    }

}
