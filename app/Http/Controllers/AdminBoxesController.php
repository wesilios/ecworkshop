<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use App\Box;
use App\Alpha;
use App\Media;
use App\Item;
use App\Brand;
use App\Tag;
use App\Color;
use App\ItemCategory;
use App\ItemStatus;
use Validator;
use Auth;
use App\Folder;

class AdminBoxesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $boxes = Box::orderBy('id', 'desc')->paginate(10);
        return view('admin.items.boxes.index', compact('boxes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $brands = Brand::all()->pluck('name','id');
        //$tags = Tag::all()->pluck('name','id');
        $colors = Color::all()->pluck('name','id');
        $statuses = ItemStatus::all()->pluck('name','id');
        return view('admin.items.boxes.create', compact('brands','colors','statuses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    	//dd($request->all());
    	$validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'summary' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'price_off' => 'nullable|numeric',
            'brand_id' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->route('boxes.create')
                        ->withErrors($validator)
                        ->withInput();
        }

        $input = $request->all();
        $item = new Item;
        $box = new Box;
        $item->name = $request->name;
        $item->description = $request->description;
        $item->summary = $request->summary;
        $item->slug = Alpha::alpha_dash($item->name);
        $item->price = $request->price;
        $item->price_off = $request->price_off;
        $item->admin_id = Auth::user()->id;
        $item->item_status_id = $request->item_status_id;
        $item->item_category_id = 1;
        $item->save();

        $box->item_id = $item->id;
        if($request->homepage_active == "on")
        {
        	$box->homepage_active = 1;
        }
        else{
        	$box->homepage_active = 0;
        }

        $box->brand_id = $request->brand_id;
        $box->slug = Alpha::alpha_dash($item->name);
        $box->item_category_id = 1;
        $box->save();
        if(isset($input['color_id']))
        {
            foreach($input['color_id'] as $input_color)
            {
                $color = Color::findOrFail($input_color);
                $box->colors()->save($color);
            }
        }
        return redirect()->route('boxes.index')->with('status','Thêm thân máy mới thành công');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $medias = Media::orderBy('id', 'desc')->get();
        $box = Box::find($id);
        $medias = Media::where('folder_id','=','1');
        $medias = $medias->orderBy('id', 'desc')->get();
        $folder = Folder::findOrFail(1);
        $folder_list = Folder::where('folder_id',$folder->id)->get();
        $new = ['folder_id' => $folder->id,'folder_name' => $folder->name, 'folder_slug'=>$folder->slug];
        $folder_string[] = $new;
        $brands = Brand::all()->pluck('name','id');
        //$tags = Tag::all()->pluck('name', 'id');
        $colors = Color::all()->pluck('name','id');
        $color_value = $box->colors->pluck('id');
        $statuses = ItemStatus::all()->pluck('name','id');
        $index_img = null;
        foreach ($box->medias as $media) {
            if($media->id == $box->item->index_img)
            {
                $index_img = $media;
            }
        }
        $media_remain = $box->medias()->where('media_id','!=',  $box->item->index_img)->get();
        //dd($index_img);
        return view('admin.items.boxes.edit', compact('box','brands','colors','color_value','medias','index_img','media_remain','statuses','folder_list','folder_string','folder'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'summary' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'price_off' => 'nullable|numeric',
            'brand_id' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->route('boxes.edit', [$id])
                        ->withErrors($validator)
                        ->withInput();
        }

        $input = $request->all();
        $box = Box::findOrFail($id);
        $item = Item::findOrFail($box->item_id);
        $item->name = $request->name;
        $item->description = $request->description;
        $item->summary = $request->summary;
        $item->price = $request->price;
        $item->price_off = $request->price_off;
        $item->item_status_id = $request->item_status_id;
        $item->save();

        if($request->homepage_active == "on")
        {
            $box->homepage_active = 1;
        }
        else{
            $box->homepage_active = 0;
        }

        $box->brand_id = $request->brand_id;
        $box->slug = Alpha::alpha_dash($item->name);
        $box->save();
        if(isset($input['color_id']))
        {
            $box->colors()->detach();
            foreach($input['color_id'] as $input_color)
            {
                $color = Color::findOrFail($input_color);
                if(in_array($input_color, $box->colors->pluck('id')->all()))
                {
                    //echo "";
                }
                else
                {
                    $box->colors()->save($color);
                }
            }
        }
        return redirect()->route('boxes.edit',[$id])->with('status','Lưu chỉnh sửa thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $box = Box::findOrFail($id);
        $item = Item::findOrFail($box->item_id);
        $box->medias()->detach();
        $box->colors()->detach();
        $box->delete();
        $item->delete();
        return redirect()->route('boxes.index')->with('delete','Xóa thân máy thành công!');
    }

    public function uploadImage(Request $request, $id)
    {
        //
        //dd($request->all());
        $files = $request->file('medias');
        $box = Box::findOrFail($id);
        if($files === null)
        {
            return redirect()->route('boxes.edit', [$id])->with('error','No input');
        }
        else
        {
            foreach($files as $file)
            {
                $file->getClientMimeType();
                //echo $file->getMimeType();
                if(substr($file->getMimeType(), 0, 5) == 'image') {
                    $name = time() . '_media_' . $file->getClientOriginalName();
                    $type = $file->getMimeType();
                    $file->move('images', $name);
                    $admin_id = Auth::user()->id;
                    $media = Media::create(['file_name'=>$name, 'url'=>$name, 'type'=>$type, 'admin_id'=>$admin_id]);
                }
                else
                {
                    return redirect()->route('boxes.edit', [$id])->with('error','Not a image file!');
                }
                if($media->id > 0)
                {
                    $box->medias()->save($media);
                }
            }
        }

        //dd($box->media);
        return redirect()->route('boxes.edit', [$id])->with('status','Cập nhật image thành công');
    }

    public function selectImage(Request $request, $id)
    {
        $input = $request->all();
        $box = Box::findOrFail($id);
        //dd($request->all());
        if($input['media_id'])
        {
            $box->medias()->detach();
            foreach($input['media_id'] as $input_media)
            {
                $media = Media::findOrFail($input_media);
                if(in_array($input_media, $box->medias->pluck('id')->all()))
                {
                    //echo "";
                }
                else
                {
                    $box->medias()->save($media);
                }
            }
        }
        return redirect()->route('boxes.edit', [$id])->with('status','Cập nhật image thành công');
    }

    public function set_image_index(Request $request, $id)
    {
        $input = $request->all();
        $box = Box::findOrFail($id);
        //dd($input['media_id']);
        $box->item->index_img = $input['media_id'];
        $box->item->save();
        return redirect()->route('boxes.edit', [$id])->with('status','Cập nhật ảnh đầu tiên thành công');
        //dd($box->item);
    }

    public function delete_image(Request $request, $id)
    {
        $input = $request->all();
        $box = Box::findOrFail($id);
        //dd($input['media_id']);
        //dd($box->medias->where('id',$input['media_id'])->first());
        $media = $box->medias->where('id',$input['media_id'])->first();

        $box->medias()->detach($input['media_id']);
        unlink(public_path() . '/images/' . $media->file_name);
        $media->delete();
        return redirect()->route('boxes.edit', [$id])->with('status','Xóa hình ảnh thành công');
    }

    public function ajaxUpload(Request $request)
    {
        if($request->ajax())
        {
            $files     = $request->file('medias');
            $folder    = Folder::find($request->folder_id);
            $box     = Box::find($request->box_id);
            $folder_id = $folder->id;

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
                $data   = view('admin.ajax.media.items.box.new_files', compact('medias', 'folder', 'box'))->render();
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
    }

    public function ajaxRemoveImg(Request $request)
    {
        if($request->ajax())
        {
            $box     = Box::find($request->box_id);
            $media = $box->medias->where('id',$request->media_id)->first();

            $box->medias()->detach($request->media_id);
            $index_img = '';
            foreach ($box->medias as $media) {
                if($media->id == $box->item->index_img)
                {
                    $index_img = $media;
                }
            }
            $media_remain = $box->medias()->where('media_id','!=',  $box->item->index_img)->get();
            $box     = Box::find($request->box_id);
            if($box->medias->isNotEmpty())
            {
                $data = view('admin.ajax.media.items.box.new_media_list', compact('box','index_img', 'media_remain'))->render();
                return response()->json([
                    'data'      => $data,
                    'box'     => $box->medias,
                    'success'   => '1',
                    'message'   => 'Sucess'
                ]);
            } else {
                $data = view('admin.ajax.media.items.box.new_media_list', compact('box','index_img', 'media_remain'))->render();
                return response()->json([
                    'data'      => $data,
                    'box'     => $box->medias,
                    'error'     => '1',
                    'message'   => 'Slider images for this item is empty'
                ]);
            }
        }
    }
}
