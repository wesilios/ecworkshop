<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Intervention\Image\ImageManagerStatic as Image;
use App\Tank;
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

class AdminTanksController extends Controller
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
        $tanks = Tank::orderBy('id', 'desc')->paginate(10);
        return view('admin.items.tanks.index', compact('tanks'));
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
        $tank_cats = ItemCategory::where('item_category_id','3')->pluck('name','id');
        $colors = Color::all()->pluck('name','id');
        $statuses = ItemStatus::all()->pluck('name','id');
        return view('admin.items.tanks.create', compact('brands','tank_cats','colors','statuses'));
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
            'tank_category_id' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->route('tanks.create')
                        ->withErrors($validator)
                        ->withInput();
        }

        $input = $request->all();
        $item = new Item;
        $tank = new Tank;
        $item->name = $request->name;
        $item->description = $request->description;
        $item->summary = $request->summary;
        $item->slug = Alpha::alpha_dash($item->name);
        $item->price = $request->price;
        $item->price_off = $request->price_off;
        $item->item_category_id = $request->tank_category_id;
        $item->admin_id = Auth::user()->id;
        $item->item_status_id = $request->item_status_id;
        $item->save();

        $tank->item_id = $item->id;
        if($request->homepage_active == "on")
        {
            $tank->homepage_active = 1;
        }
        else{
            $tank->homepage_active = 0;
        }

        $tank->brand_id = $request->brand_id;
        $tank->slug = Alpha::alpha_dash($item->name);
        $tank->item_category_id = $request->tank_category_id;
        $tank->save();
        if(isset($input['color_id']))
        {
            foreach($input['color_id'] as $input_color)
            {
                $color = Color::findOrFail($input_color);
                $tank->colors()->save($color);
            }
        }
        return redirect()->route('tanks.index')->with('status','Thêm buồng đốt mới thành công');
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
        $tank = Tank::findOrFail($id);
        $tank = Tank::find($id);
        $medias = Media::where('folder_id','=','1');
        $medias = $medias->orderBy('id', 'desc')->get();
        $folder = Folder::findOrFail(1);
        $folder_list = Folder::where('folder_id',$folder->id)->get();
        $new = ['folder_id' => $folder->id,'folder_name' => $folder->name, 'folder_slug'=>$folder->slug];
        $folder_string[] = $new;
        $brands = Brand::all()->pluck('name','id');
        //$tags = Tag::all()->pluck('name', 'id');
        $tank_cats = ItemCategory::where('item_category_id','3')->pluck('name','id');
        $colors = Color::all()->pluck('name','id');
        $color_value = $tank->colors->pluck('id');
        $statuses = ItemStatus::all()->pluck('name','id');
        $index_img = null;
        foreach ($tank->medias as $media) {
            if($media->id == $tank->item->index_img)
            {
                $index_img = $media;
            }
        }
        $media_remain = $tank->medias()->where('media_id','!=',  $tank->item->index_img)->get();
        return view('admin.items.tanks.edit', compact('tank','brands','tank_cats','medias','color_value','colors','index_img','media_remain','statuses','folder_list','folder_string','folder'));
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
            'brand_id' => 'required',
            'tank_category_id' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->route('tanks.edit',[$id])
                        ->withErrors($validator)
                        ->withInput();
        }

        $input = $request->all();
        $tank = Tank::findOrFail($id);
        $item = Item::findOrFail($tank->item_id);
        $item->name = $request->name;
        $item->description = $request->description;
        $item->summary = $request->summary;
        $item->price = $request->price;
        $item->price_off = $request->price_off;
        $item->item_category_id = $request->tank_category_id;
        $item->item_status_id = $request->item_status_id;
        $item->save();

        if($request->homepage_active == "on")
        {
            $tank->homepage_active = 1;
        }
        else{
            $tank->homepage_active = 0;
        }

        $tank->brand_id = $request->brand_id;
        $tank->slug = Alpha::alpha_dash($item->name);
        $tank->item_category_id = $request->tank_category_id;
        $tank->save();
        if(isset($input['color_id']))
        {
            $tank->colors()->detach();
            foreach($input['color_id'] as $input_color)
            {
                $color = Color::findOrFail($input_color);
                if(in_array($input_color, $tank->colors->pluck('id')->all()))
                {
                    //echo "";
                }
                else
                {
                    $tank->colors()->save($color);
                }
            }
        }
        return redirect()->route('tanks.edit',[$id])->with('status','Lưu chỉnh sửa thành công');
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
        $tank = Tank::findOrFail($id);
        $item = Item::findOrFail($tank->item_id);
        $tank->colors()->detach();
        $tank->medias()->detach();
        $tank->delete();
        $item->delete();
        return redirect()->route('tanks.index')->with('delete','Xóa buồng đốt thành công!');
    }

    public function uploadImage(Request $request, $id)
    {
        //
        //dd($request->all());
        $files = $request->file('medias');
        $tank = Tank::findOrFail($id);
        if($files === null)
        {
            return redirect()->route('tanks.edit', [$id])->with('error','No input');
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
                    return redirect()->route('tanks.edit', [$id])->with('error','Not a image file!');
                }
                if($media->id > 0)
                {
                    $tank->medias()->save($media);
                }
            }
        }

        //dd($tank->media);
        return redirect()->route('tanks.edit', [$id])->with('status','Cập nhật image thành công');
    }

    public function selectImage(Request $request, $id)
    {
        $input = $request->all();
        $tank = Tank::findOrFail($id);
        if($request->get('media_id'))
        {
            $tank->medias()->detach();
            foreach($input['media_id'] as $input_media)
            {
                $media = Media::findOrFail($input_media);
                if(in_array($input_media, $tank->medias->pluck('id')->all()))
                {
                    //echo "";
                }
                else
                {
                    $tank->medias()->save($media);
                }
            }
            return redirect()->route('tanks.edit', [$id])->with('status','Cập nhật image thành công');
        } else {
            return redirect()->route('tanks.edit', [$id])->with('status','Vui lòng chọn ảnh cần cập nhật');
        }
    }

    public function set_image_index(Request $request, $id)
    {
        $input = $request->all();
        $tank = Tank::findOrFail($id);
        $tank->item->index_img = $input['media_id'];
        $tank->item->save();
        foreach ($tank->medias as $media) {
            if($media->id == $tank->item->index_img)
            {
                echo "found it";
            }
        }
        return redirect()->route('tanks.edit', [$id])->with('status','Cập nhật ảnh đầu tiên thành công');
        //dd($tank->item);
    }

    public function delete_image(Request $request, $id)
    {
        $input = $request->all();
        $tank = Tank::findOrFail($id);
        //dd($input['media_id']);
        //dd($tank->medias->where('id',$input['media_id'])->first());
        $media = $tank->medias->where('id',$input['media_id'])->first();

        $tank->medias()->detach($input['media_id']);
        unlink(public_path() . '/images/' . $media->file_name);
        $media->delete();
        return redirect()->route('tanks.edit', [$id])->with('status','Xóa hình ảnh thành công');
    }

    public function ajaxUpload(Request $request)
    {
        if($request->ajax())
        {
            $files     = $request->file('medias');
            $folder    = Folder::find($request->folder_id);
            $tank     = Tank::find($request->tank_id);
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
                $data   = view('admin.ajax.media.items.tank.new_files', compact('medias', 'folder', 'tank'))->render();
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
            $tank     = Tank::find($request->tank_id);
            $media = $tank->medias->where('id',$request->media_id)->first();

            $tank->medias()->detach($request->media_id);
            $index_img = '';
            foreach ($tank->medias as $media) {
                if($media->id == $tank->item->index_img)
                {
                    $index_img = $media;
                }
            }
            $media_remain = $tank->medias()->where('media_id','!=',  $tank->item->index_img)->get();
            $tank     = Tank::find($request->tank_id);
            if($tank->medias->isNotEmpty())
            {
                $data = view('admin.ajax.media.items.tank.new_media_list', compact('tank','index_img', 'media_remain'))->render();
                return response()->json([
                    'data'      => $data,
                    'tank'      => $tank->medias,
                    'success'   => '1',
                    'message'   => 'Sucess'
                ]);
            } else {
                $data = view('admin.ajax.media.items.tank.new_media_list', compact('tank','index_img', 'media_remain'))->render();
                return response()->json([
                    'data'      => $data,
                    'tank'      => $tank->medias,
                    'error'     => '1',
                    'message'   => 'Slider images for this item is empty'
                ]);
            }
        }
    }
}
