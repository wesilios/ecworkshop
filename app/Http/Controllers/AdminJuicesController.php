<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use App\Juice;
use App\Alpha;
use App\Media;
use App\Item;
use App\Brand;
use App\Folder;
use App\Tag;
use App\ItemCategory;
use App\ItemStatus;
use App\Size;
use Validator;
use Auth;

class AdminJuicesController extends Controller
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
        $juices = Juice::orderBy('id', 'desc')->paginate(10);
        return view('admin.items.juices.index', compact('juices'));
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
        $juice_cats = ItemCategory::where('item_category_id','4')->pluck('name','id');
        $juice_sizes = Size::all()->pluck('name','id');
        $statuses = ItemStatus::all()->pluck('name','id');
        return view('admin.items.juices.create', compact('brands','juice_cats','juice_sizes','statuses'));
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
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'summary' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'price_off' => 'nullable|numeric',
            'brand_id' => 'required',
            'juice_category_id' => 'required',
            'size_id' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->route('juices.create')
                        ->withErrors($validator)
                        ->withInput();
        }

        $input = $request->all();
        $item = new Item;
        $juice = new Juice;
        $item->name = $request->name;
        $item->description = $request->description;
        $item->summary = $request->summary;
        $item->slug = Alpha::alpha_dash($item->name);
        $item->price = $request->price;
        $item->price_off = $request->price_off;
        $item->item_category_id = $request->juice_category_id;
        $item->admin_id = Auth::user()->id;
        $item->item_status_id = $request->item_status_id;
        $item->save();

        $juice->item_id = $item->id;
        if($request->homepage_active == "on")
        {
            $juice->homepage_active = 1;
        }
        else{
            $juice->homepage_active = 0;
        }

        $juice->brand_id = $request->brand_id;
        $juice->slug = Alpha::alpha_dash($item->name);
        $juice->size_id = $request->size_id;
        $juice->item_category_id = $request->juice_category_id;
        $juice->save();
        return redirect()->route('juices.index')->with('status','Thêm tinh dầu mới thành công');
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
        $juice = Juice::find($id);
        $medias = Media::where('folder_id','=','1');
        $medias = $medias->orderBy('id', 'desc')->get();
        $folder = Folder::findOrFail(1);
        $folder_list = Folder::where('folder_id',$folder->id)->get();
        $new = ['folder_id' => $folder->id,'folder_name' => $folder->name, 'folder_slug'=>$folder->slug];
        $folder_string[] = $new;
        $brands = Brand::all()->pluck('name','id');
        //$tags = Tag::all()->pluck('name', 'id');
        $juice_cats = ItemCategory::where('item_category_id','4')->pluck('name','id');
        $juice_sizes = Size::all()->pluck('name','id');
        $statuses = ItemStatus::all()->pluck('name','id');
        $index_img = null;
        foreach ($juice->medias as $media) {
            if($media->id == $juice->item->index_img)
            {
                $index_img = $media;
            }
        }
        $media_remain = $juice->medias()->where('media_id','!=',  $juice->item->index_img)->get();
        return view('admin.items.juices.edit', compact('juice','brands','juice_cats','medias','juice_sizes','index_img','media_remain','statuses','folder_list','folder_string','folder'));
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
        //dd($request->all());
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'summary' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'price_off' => 'nullable|numeric',
            'brand_id' => 'required',
            'juice_category_id' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->route('juices.edit',[$id])
                        ->withErrors($validator)
                        ->withInput();
        }

        $input = $request->all();
        $juice = Juice::findOrFail($id);
        $item = Item::findOrFail($juice->item_id);
        $item->name = $request->name;
        $item->description = $request->description;
        $item->summary = $request->summary;
        $item->price = $request->price;
        $item->price_off = $request->price_off;
        $item->item_category_id = $request->juice_category_id;
        $item->item_status_id = $request->item_status_id;
        $item->save();

        if($request->homepage_active == "on")
        {
            $juice->homepage_active = 1;
        }
        else{
            $juice->homepage_active = 0;
        }

        $juice->brand_id = $request->brand_id;
        $juice->slug = Alpha::alpha_dash($item->name);
        $juice->size_id = $request->size_id;
        $juice->item_category_id = $request->juice_category_id;
        $juice->save();

        return redirect()->route('juices.edit', [$id])->with('status','Lưu chỉnh sửa thành công');
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
        $juice = Juice::findOrFail($id);
        $item = Item::findOrFail($juice->item_id);
        $juice->colors()->detach();
        $juice->medias()->detach();
        $juice->delete();
        $item->delete();
        return redirect()->route('juices.index')->with('delete','Xóa tinh dầu thành công!');
    }

    public function uploadImage(Request $request, $id)
    {
    	$files = $request->file('medias');
        $juice = Juice::findOrFail($id);
        if($files === null)
        {
            return redirect()->route('juices.edit', [$id])->with('error','No input');
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
                    return redirect()->route('juices.edit', [$id])->with('error','Not a image file!');
                }
                if($media->id > 0)
                {
                    $juice->medias()->save($media);
                }
            }
        }

        //dd($juice->media);
        return redirect()->route('juices.edit', [$id])->with('status','Cập nhật image thành công');
    }

    public function selectImage(Request $request, $id)
    {
    	$input = $request->all();
        $juice = Juice::findOrFail($id);
        //dd($request->all());
        if($input['media_id'])
        {
            $juice->medias()->detach();
            foreach($input['media_id'] as $input_media)
            {
                $media = Media::findOrFail($input_media);
                if(in_array($input_media, $juice->medias->pluck('id')->all()))
                {
                    //echo "";
                }
                else
                {
                    $juice->medias()->save($media);
                }
            }
        }
        return redirect()->route('juices.edit', [$id])->with('status','Cập nhật image thành công');
    }

    public function set_image_index(Request $request, $id)
    {
        $input = $request->all();
        $juice = Juice::findOrFail($id);
        //dd($input['media_id']);
        $juice->item->index_img = $input['media_id'];
        $juice->item->save();
        foreach ($juice->medias as $media) {
            if($media->id == $juice->item->index_img)
            {
                echo "found it";
            }
        }
        return redirect()->route('juices.edit', [$id])->with('status','Cập nhật ảnh đầu tiên thành công');
        //dd($juice->item);
    }

    public function delete_image(Request $request, $id)
    {
        $input = $request->all();
        $juice = Juice::findOrFail($id);
        //dd($input['media_id']);
        //dd($juice->medias->where('id',$input['media_id'])->first());
        $media = $juice->medias->where('id',$input['media_id'])->first();

        $juice->medias()->detach($input['media_id']);
        unlink(public_path() . '/images/' . $media->file_name);
        $media->delete();
        return redirect()->route('juices.edit', [$id])->with('status','Xóa hình ảnh thành công');
    }

    public function ajaxUpload(Request $request)
    {
        if($request->ajax())
        {
            $files     = $request->file('medias');
            $folder    = Folder::find($request->folder_id);
            $juice     = Juice::find($request->juice_id);
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
                $data   = view('admin.ajax.media.items.juice.new_files', compact('medias', 'folder', 'juice'))->render();
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
            $juice     = Juice::find($request->juice_id);
            $media = $juice->medias->where('id',$request->media_id)->first();

            $juice->medias()->detach($request->media_id);
            $index_img = '';
            foreach ($juice->medias as $media) {
                if($media->id == $juice->item->index_img)
                {
                    $index_img = $media;
                }
            }
            $media_remain = $juice->medias()->where('media_id','!=',  $juice->item->index_img)->get();
            $juice     = Juice::find($request->juice_id);
            if($juice->medias->isNotEmpty())
            {
                $data = view('admin.ajax.media.items.juice.new_media_list', compact('juice','index_img', 'media_remain'))->render();
                return response()->json([
                    'data'      => $data,
                    'juice'     => $juice->medias,
                    'success'   => '1',
                    'message'   => 'Sucess'
                ]);
            } else {
                $data = view('admin.ajax.media.items.juice.new_media_list', compact('juice','index_img', 'media_remain'))->render();
                return response()->json([
                    'data'      => $data,
                    'juice'     => $juice->medias,
                    'error'     => '1',
                    'message'   => 'Slider images for this item is empty'
                ]);
            }
        }
    }
}
