<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use App\Accessory;
use App\Alpha;
use App\Media;
use App\Item;
use App\Brand;
use App\Tag;
use App\ItemCategory;
use App\ItemStatus;
use Validator;
use Auth;

class AdminAccessoriesController extends Controller
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
        $accessories = Accessory::orderBy('id', 'desc')->paginate(10);
        return view('admin.items.accessories.index', compact('accessories'));
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
        $statuses = ItemStatus::all()->pluck('name','id');
        $accessory_cats = ItemCategory::where('item_category_id','5')->pluck('name','id');
        return view('admin.items.accessories.create', compact('brands','accessory_cats','statuses'));
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
            'accessory_category_id' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->route('accessories.create')
                        ->withErrors($validator)
                        ->withInput();
        }

        $input = $request->all();
        $item = new Item;
        $accessory = new Accessory;
        $item->name = $request->name;
        $item->description = $request->description;
        $item->summary = $request->summary;
        $item->slug = Alpha::alpha_dash($item->name);
        $item->price = $request->price;
        $item->price_off = $request->price_off;
        $item->admin_id = Auth::user()->id;
        $item->item_category_id = $request->accessory_category_id;
        $item->item_status_id = $request->item_status_id;
        $item->save();

        $accessory->item_id = $item->id;
        if($request->homepage_active == "on")
        {
            $accessory->homepage_active = 1;
        }
        else{
            $accessory->homepage_active = 0;
        }
        
        $accessory->brand_id = $request->brand_id;
        $accessory->slug = Alpha::alpha_dash($item->name);
        $accessory->item_category_id = $request->accessory_category_id;
        $accessory->save();
        return redirect()->route('accessories.index')->with('status','Thêm buồng đốt mới thành công');
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
        $accessory = Accessory::findOrFail($id);
        $brands = Brand::all()->pluck('name','id');
        //$tags = Tag::all()->pluck('name', 'id');
        $statuses = ItemStatus::all()->pluck('name','id');
        $accessory_cats = ItemCategory::where('item_category_id','5')->pluck('name','id');
        $index_img = null;
        foreach ($accessory->medias as $media) {
            if($media->id == $accessory->item->index_img)
            {
                $index_img = $media;
            }
        }
        $media_remain = $accessory->medias()->where('media_id','!=',  $accessory->item->index_img)->get();
        return view('admin.items.accessories.edit', compact('accessory','brands','accessory_cats','medias','index_img','media_remain','statuses'));
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
            'accessory_category_id' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->route('accessories.edit',[$id])
                        ->withErrors($validator)
                        ->withInput();
        }

        $input = $request->all();
        $accessory = Accessory::findOrFail($id);
        $item = Item::findOrFail($accessory->item_id);
        $item->name = $request->name;
        $item->description = $request->description;
        $item->summary = $request->summary;
        $item->price = $request->price;
        $item->price_off = $request->price_off;
        $item->item_category_id = $request->accessory_category_id;
        $item->item_status_id = $request->item_status_id;
        $item->save();

        if($request->homepage_active == "on")
        {
            $accessory->homepage_active = 1;
        }
        else{
            $accessory->homepage_active = 0;
        }
        
        $accessory->brand_id = $request->brand_id;
        $accessory->slug = Alpha::alpha_dash($item->name);
        $accessory->item_category_id = $request->accessory_category_id;
        $accessory->save();
        
        return redirect()->route('accessories.edit',[$id])->with('status','Lưu chỉnh sửa thành công');
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
        $accessory = Accessory::findOrFail($id);
        $item = Item::findOrFail($accessory->item_id);
        $accessory->colors()->detach();
        $accessory->medias()->detach();
        $accessory->delete();
        $item->delete();
        return redirect()->route('accessories.index')->with('delete','Xóa phụ kiện thành công!');
    }

    public function uploadImage(Request $request, $id)
    {
        //
        //dd($request->all());
        $files = $request->file('medias');
        $accessory = Accessory::findOrFail($id);
        if($files === null)
        {
            return redirect()->route('accessories.edit', [$id])->with('error','No input');
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
                    return redirect()->route('accessories.edit', [$id])->with('error','Not a image file!');
                }
                if($media->id > 0)
                {
                    $accessory->medias()->save($media);
                }
            }
        }

        //dd($accessory->media);
        return redirect()->route('accessories.edit', [$id])->with('status','Cập nhật image thành công');
    }

    public function selectImage(Request $request, $id)
    {
        $input = $request->all();
        $accessory = Accessory::findOrFail($id);
        //dd($request->all());
        if($input['media_id'])
        {
            $accessory->medias()->detach();
            foreach($input['media_id'] as $input_media)
            {
                $media = Media::findOrFail($input_media);
                if(in_array($input_media, $accessory->medias->pluck('id')->all()))
                {
                    //echo "";
                }
                else
                {
                    $accessory->medias()->save($media);
                }
            }
        }
        return redirect()->route('accessories.edit', [$id])->with('status','Cập nhật image thành công');
    }

    public function set_image_index(Request $request, $id)
    {
        $input = $request->all();
        $accessory = Accessory::findOrFail($id);
        //dd($input['media_id']);
        $accessory->item->index_img = $input['media_id'];
        $accessory->item->save();
        foreach ($accessory->medias as $media) {
            if($media->id == $accessory->item->index_img)
            {
                echo "found it";
            }
        }
        return redirect()->route('accessories.edit', [$id])->with('status','Cập nhật ảnh đầu tiên thành công');
        //dd($accessory->item);
    }

    public function delete_image(Request $request, $id)
    {
        $input = $request->all();
        $accessory = Accessory::findOrFail($id);
        //dd($input['media_id']);
        //dd($accessory->medias->where('id',$input['media_id'])->first());
        $media = $accessory->medias->where('id',$input['media_id'])->first();

        $accessory->medias()->detach($input['media_id']);
        unlink(public_path() . '/images/' . $media->file_name);
        $media->delete();
        return redirect()->route('accessories.edit', [$id])->with('status','Xóa hình ảnh thành công');
    }
}
