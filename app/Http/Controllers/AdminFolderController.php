<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
            $folder = new Folder;
            $folder->name = $request->folder_name;
            $folder->slug = Alpha::alpha_dash($request->folder_name);
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
