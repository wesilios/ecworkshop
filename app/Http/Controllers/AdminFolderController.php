<?php

namespace App\Http\Controllers;

use App\Article;
use http\Env\Response;
use Illuminate\Http\Request;
use Auth;
use Validator;
use App\Folder;
use App\Alpha;
use App\Media;
use App\Accessory;
use App\Box;
use App\FullKit;
use App\Juice;
use App\Tank;
use App\Item;
use App\ItemCategory;

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



    public function show($id, $slug)
    {
    	try {
            $folder = Folder::where([['id',$id],['slug',$slug]])->first();
            $folder_list = Folder::where('folder_id', $folder->id)->get();
            $medias = Media::where('folder_id',$folder->id)->orderBy('id', 'desc')->paginate(24);
            $folder_id_parent = $folder->folder->id;
//    	$folder_string = [['folder_id' => '1','folder_name'=>'root','folder_slug'=>'root']];
            $folder_string = [['folder_id'=>$folder->id,'folder_name'=>$folder->name,'folder_slug'=>$folder->slug]];

            while($folder_id_parent != 1)
            {
                $folder_temp = Folder::findOrFail($folder_id_parent);
                $folder_id_parent = $folder_temp->folder->id;
                $new = ['folder_id' => $folder_temp->id,'folder_name' => $folder_temp->name, 'folder_slug'=>$folder_temp->slug];
                $folder_string[] = $new;
            }
            $folder_string[] = ['folder_id' => '1','folder_name'=>'root','folder_slug'=>'root'];
            return view('admin.media.index', compact('medias','folder','folder_list','folder_string'));
        } catch (\Exception $e) {
    	    return redirect()->back()->with(['status'=>'error', 'message'=>$e->getMessage()]);
        }
    }

    public function ajaxModalMedia(Request $request)
    {
        if($request->ajax()) {
            $article = Article::find($request->get('article_id'));

            $slug = $request->get('folder_slug');
            $folder = Folder::where('slug',$slug)->first();
            $folder_list = Folder::where('folder_id', $folder->id)->get();
            $medias = Media::where('folder_id',$folder->id);
            if($article->media->first())
            {
                $medias = $medias->where('id','!=',$article->media->first()->id);
            }
            $medias = $medias->orderBy('id', 'desc')->get();
            $folder_id_parent = $folder->folder->id;
            $folder_string = [['folder_id' => '1','folder_name'=>'root','folder_slug'=>'root']];

            while($folder_id_parent != 1)
            {
                $folder_temp = Folder::findOrFail($folder_id_parent);
                $folder_id_parent = $folder_temp->folder->id;
                $new = ['folder_id' => $folder_temp->id,'folder_name' => $folder_temp->name, 'folder_slug'=>$folder_temp->slug];
                $folder_string[] = $new;
            }

            if($folder->id != 1)
            {
                $new = ['folder_id' => $folder->id,'folder_name' => $folder->name, 'folder_slug'=>$folder->slug];
                $folder_string[] = $new;
            }
            $data = view('admin.ajax.media.article', compact('medias','folder','folder_list','folder_string','article'))->render();
            return response()->json(['option'=>$data, 'folder_id' => $folder->id, 'folder_string' =>$folder_string ]);
        }
    }

    public function ajaxJuiceModalShow(Request $request)
    {
        if($request->ajax())
        {
            $juice = Juice::find($request->juice_id);

            $slug = $request->get('folder_slug');
            $folder = Folder::where('slug',$slug)->first();
            $folder_list = Folder::where('folder_id', $folder->id)->get();
            $medias = Media::where('folder_id',$folder->id);
            $medias = $medias->orderBy('id', 'desc')->get();
            $folder_id_parent = $folder->folder->id;
            $folder_string = [['folder_id' => '1','folder_name'=>'root','folder_slug'=>'root']];

            while($folder_id_parent != 1)
            {
                $folder_temp = Folder::findOrFail($folder_id_parent);
                $folder_id_parent = $folder_temp->folder->id;
                $new = ['folder_id' => $folder_temp->id,'folder_name' => $folder_temp->name, 'folder_slug'=>$folder_temp->slug];
                $folder_string[] = $new;
            }

            if($folder->id != 1)
            {
                $new = ['folder_id' => $folder->id,'folder_name' => $folder->name, 'folder_slug'=>$folder->slug];
                $folder_string[] = $new;
            }
            $data = view('admin.ajax.media.items.juice.juice', compact('medias','folder','folder_list','folder_string','juice'))->render();
            return response()->json(['option'=>$data, 'folder_id' => $folder->id, 'folder_string' =>$folder_string ]);
        }
    }

    public function ajaxAccessoryModalShow(Request $request)
    {
        if($request->ajax())
        {
            $accessory = Accessory::find($request->accessory_id);

            $slug = $request->get('folder_slug');
            $folder = Folder::where('slug',$slug)->first();
            $folder_list = Folder::where('folder_id', $folder->id)->get();
            $medias = Media::where('folder_id',$folder->id);
            $medias = $medias->orderBy('id', 'desc')->get();
            $folder_id_parent = $folder->folder->id;
            $folder_string = [['folder_id' => '1','folder_name'=>'root','folder_slug'=>'root']];

            while($folder_id_parent != 1)
            {
                $folder_temp = Folder::findOrFail($folder_id_parent);
                $folder_id_parent = $folder_temp->folder->id;
                $new = ['folder_id' => $folder_temp->id,'folder_name' => $folder_temp->name, 'folder_slug'=>$folder_temp->slug];
                $folder_string[] = $new;
            }

            if($folder->id != 1)
            {
                $new = ['folder_id' => $folder->id,'folder_name' => $folder->name, 'folder_slug'=>$folder->slug];
                $folder_string[] = $new;
            }
            $data = view('admin.ajax.media.items.accessory.accessory', compact('medias','folder','folder_list','folder_string','accessory'))->render();
            return response()->json(['option'=>$data, 'folder_id' => $folder->id, 'folder_string' =>$folder_string ]);
        }
    }

    public function ajaxBoxModalShow(Request $request)
    {
        if($request->ajax())
        {
            $box = Box::find($request->box_id);

            $slug = $request->get('folder_slug');
            $folder = Folder::where('slug',$slug)->first();
            $folder_list = Folder::where('folder_id', $folder->id)->get();
            $medias = Media::where('folder_id',$folder->id);
            $medias = $medias->orderBy('id', 'desc')->get();
            $folder_id_parent = $folder->folder->id;
            $folder_string = [['folder_id' => '1','folder_name'=>'root','folder_slug'=>'root']];

            while($folder_id_parent != 1)
            {
                $folder_temp = Folder::findOrFail($folder_id_parent);
                $folder_id_parent = $folder_temp->folder->id;
                $new = ['folder_id' => $folder_temp->id,'folder_name' => $folder_temp->name, 'folder_slug'=>$folder_temp->slug];
                $folder_string[] = $new;
            }

            if($folder->id != 1)
            {
                $new = ['folder_id' => $folder->id,'folder_name' => $folder->name, 'folder_slug'=>$folder->slug];
                $folder_string[] = $new;
            }
            $data = view('admin.ajax.media.items.box.box', compact('medias','folder','folder_list','folder_string','box'))->render();
            return response()->json(['option'=>$data, 'folder_id' => $folder->id, 'folder_string' =>$folder_string ]);
        }
    }

    public function ajaxTankModalShow(Request $request)
    {
        if($request->ajax())
        {
            $tank = Tank::find($request->tank_id);

            $slug = $request->get('folder_slug');
            $folder = Folder::where('slug',$slug)->first();
            $folder_list = Folder::where('folder_id', $folder->id)->get();
            $medias = Media::where('folder_id',$folder->id);
            $medias = $medias->orderBy('id', 'desc')->get();
            $folder_id_parent = $folder->folder->id;
            $folder_string = [['folder_id' => '1','folder_name'=>'root','folder_slug'=>'root']];

            while($folder_id_parent != 1)
            {
                $folder_temp = Folder::findOrFail($folder_id_parent);
                $folder_id_parent = $folder_temp->folder->id;
                $new = ['folder_id' => $folder_temp->id,'folder_name' => $folder_temp->name, 'folder_slug'=>$folder_temp->slug];
                $folder_string[] = $new;
            }

            if($folder->id != 1)
            {
                $new = ['folder_id' => $folder->id,'folder_name' => $folder->name, 'folder_slug'=>$folder->slug];
                $folder_string[] = $new;
            }
            $data = view('admin.ajax.media.items.tank.tank', compact('medias','folder','folder_list','folder_string','tank'))->render();
            return response()->json(['option'=>$data, 'folder_id' => $folder->id, 'folder_string' =>$folder_string ]);
        }
    }

    public function ajaxFullKitModalShow(Request $request)
    {
        if($request->ajax())
        {
            $fullkit = FullKit::find($request->fullkit_id);

            $slug = $request->get('folder_slug');
            $folder = Folder::where('slug',$slug)->first();
            $folder_list = Folder::where('folder_id', $folder->id)->get();
            $medias = Media::where('folder_id',$folder->id);
            $medias = $medias->orderBy('id', 'desc')->get();
            $folder_id_parent = $folder->folder->id;
            $folder_string = [['folder_id' => '1','folder_name'=>'root','folder_slug'=>'root']];

            while($folder_id_parent != 1)
            {
                $folder_temp = Folder::findOrFail($folder_id_parent);
                $folder_id_parent = $folder_temp->folder->id;
                $new = ['folder_id' => $folder_temp->id,'folder_name' => $folder_temp->name, 'folder_slug'=>$folder_temp->slug];
                $folder_string[] = $new;
            }

            if($folder->id != 1)
            {
                $new = ['folder_id' => $folder->id,'folder_name' => $folder->name, 'folder_slug'=>$folder->slug];
                $folder_string[] = $new;
            }
            $data = view('admin.ajax.media.items.fullkit.fullkit', compact('medias','folder','folder_list','folder_string','fullkit'))->render();
            return response()->json(['option'=>$data, 'folder_id' => $folder->id, 'folder_string' =>$folder_string ]);
        }
    }

    public function ajaxItemModalShow(Request $request)
    {
        if($request->ajax())
        {
            $item = Item::find($request->item_id);

            $slug = $request->get('folder_slug');
            $folder = Folder::where('slug',$slug)->first();
            $folder_list = Folder::where('folder_id', $folder->id)->get();
            $medias = Media::where('folder_id',$folder->id);
            $medias = $medias->orderBy('id', 'desc')->get();
            $folder_id_parent = $folder->folder->id;
            $folder_string = [['folder_id' => '1','folder_name'=>'root','folder_slug'=>'root']];

            while($folder_id_parent != 1)
            {
                $folder_temp = Folder::findOrFail($folder_id_parent);
                $folder_id_parent = $folder_temp->folder->id;
                $new = ['folder_id' => $folder_temp->id,'folder_name' => $folder_temp->name, 'folder_slug'=>$folder_temp->slug];
                $folder_string[] = $new;
            }

            if($folder->id != 1)
            {
                $new = ['folder_id' => $folder->id,'folder_name' => $folder->name, 'folder_slug'=>$folder->slug];
                $folder_string[] = $new;
            }
            $data = view('admin.ajax.media.items.item', compact('medias','folder','folder_list','folder_string','item'))->render();
            return response()->json(['option'=>$data, 'folder_id' => $folder->id, 'folder_string' =>$folder_string ]);
        }
    }

    public function createJuiceAjax(Request $request)
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

            $juice = Juice::find($request->juice_id);
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
            $data = view('admin.ajax.media.items.juice.new_folder',compact('folder','folder_list', 'juice'))->render();
            return response()->json(['option'=>$data]);
        }
    }

    public function createAccessoryAjax(Request $request)
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

            $accessory = Accessory::find($request->accessory_id);
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
            $data = view('admin.ajax.media.items.accessory.new_folder',compact('folder','folder_list', 'accessory'))->render();
            return response()->json(['option'=>$data]);
        }
    }

    public function createBoxAjax(Request $request)
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

            $box = Box::find($request->box_id);
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
            $data = view('admin.ajax.media.items.box.new_folder',compact('folder','folder_list', 'box'))->render();
            return response()->json(['option'=>$data]);
        }
    }

    public function createTankAjax(Request $request)
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

            $tank = Tank::find($request->tank_id);
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
            $data = view('admin.ajax.media.items.tank.new_folder',compact('folder','folder_list', 'tank'))->render();
            return response()->json(['option'=>$data]);
        }
    }

    public function createFullKitAjax(Request $request)
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

            $fullkit = FullKit::find($request->fullkit_id);
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
            $data = view('admin.ajax.media.items.fullkit.new_folder',compact('folder','folder_list', 'fullkit'))->render();
            return response()->json(['option'=>$data]);
        }
    }

    public function createItemAjax(Request $request)
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

            $item = Item::find($request->item_id);
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
            $data = view('admin.ajax.media.items.new_folder',compact('folder','folder_list', 'item'))->render();
            return response()->json(['option'=>$data]);
        }
    }

    public function rename(Request $rq)
    {
        try {
            $folder = Folder::where([
               ['id',$rq->folder_id],
               ['slug',$rq->folder_slug]
            ])->first();
            $folder->name = Alpha::alpha_dash($rq->folder_name);
            $folder->slug = Alpha::alpha_dash($rq->folder_name);
            $folder->origin = Alpha::alpha_dash($rq->folder_name);
            $path = '';
            $folder_id_parent = '';
            $path_old = '';
            $path_new = '';
            if($folder->folder_id == 1) {
                $path_old .= '/images/' . $rq->folder_slug;
                $path_new .= '/images/' . $folder->slug;
            }
            else
            {
                $folder_id_parent = $folder->folder_id;
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
                $path_old = $path . $rq->folder_slug;
                $path_new = $path . $folder->slug;
            }
            $path_old = public_path($path_old);
            $path_new = public_path($path_new);
            rename($path_old,$path_new);
            $folder->save();
            return redirect()->back()->with('status','Update successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('status',$e->getMessage());
        }
    }

    public function delete(Request $rq)
    {
        try {
            $folder = Folder::where([
                ['id',$rq->folder_id],
                ['slug',$rq->folder_slug]
            ])->first();
            $folder->name = Alpha::alpha_dash($rq->folder_name);
            $folder->slug = Alpha::alpha_dash($rq->folder_name);
            $folder->origin = Alpha::alpha_dash($rq->folder_name);
            $path = '';
            $folder_id_parent = '';
            $path_old = '';
            $path_new = '';
            if($folder->folder_id == 1) {
                $path_old .= '/images/' . $rq->folder_slug;
                $path_new .= '/images/' . $folder->slug;
            }
            else
            {
                $folder_id_parent = $folder->folder_id;
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
                $path_old = $path . $rq->folder_slug;
            }
            $path_old = public_path($path_old);
            if($this->checkIfNotEmpty($folder)){
                return redirect()->back()->with('status','Folder is not empty! Delete sub-folder first');
            } else {
                rmdir($path_old .'/');
                $folder->delete();
                return redirect()->back()->with('status','Delete successfully');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('status',$e->getMessage());
        }
    }

    public function checkIfNotEmpty($folder){
        if($folder->folders->count()>0 || $folder->medias->isNotEmpty()){
            return $folder->folders;
        } else {
            return false;
        }
    }
}
