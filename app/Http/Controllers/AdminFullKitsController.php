<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use App\FullKit;
use App\Alpha;
use App\Media;
use App\Item;
use App\Brand;
use App\Tag;
use App\Color;
use App\ItemStatus;
use Validator;
use Auth;

class AdminFullKitsController extends Controller
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
        $fullkits = FullKit::paginate(10);
        return view('admin.items.fullkits.index', compact('fullkits'));
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
        return view('admin.items.fullkits.create', compact('brands','colors','statuses'));
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
            'brand_id' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->route('fullkits.create')
                        ->withErrors($validator)
                        ->withInput();
        }

        $input = $request->all();
        $item = new Item;
        $fullkit = new FullKit;
        $item->name = $request->name;
        $item->description = $request->description;
        $item->summary = $request->summary;
        $item->slug = Alpha::alpha_dash($item->name);
        $item->price = $request->price;
        $item->price_off = $request->price_off;
        $item->item_status_id = $request->item_status_id;
        $item->item_category_id = 2;
        $item->admin_id = Auth::user()->id;
        $item->save();

        $fullkit->item_id = $item->id;
        if($request->homepage_active == "on")
        {
            $fullkit->homepage_active = 1;
        }
        else{
            $fullkit->homepage_active = 0;
        }
        
        $fullkit->brand_id = $request->brand_id;
        $fullkit->slug = Alpha::alpha_dash($item->name);
        $fullkit->item_category_id = 2;
        $fullkit->save();
        if(isset($input['color_id']))
        {
            foreach($input['color_id'] as $input_color)
            {
                $color = Color::findOrFail($input_color);
                $fullkit->colors()->save($color);
            }
        }
        return redirect()->route('fullkits.index')->with('status','Thêm full kits mới thành công');
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
        $fullkit = FullKit::findOrFail($id);
        $brands = Brand::all()->pluck('name','id');
        //$tags = Tag::all()->pluck('name', 'id');
        $colors = Color::all()->pluck('name','id');
        $color_value = $fullkit->colors->pluck('id');
        $statuses = ItemStatus::all()->pluck('name','id');
        $index_img = null;
        foreach ($fullkit->medias as $media) {
            if($media->id == $fullkit->item->index_img)
            {
                $index_img = $media;
            }
        }
        $media_remain = $fullkit->medias()->where('media_id','!=',  $fullkit->item->index_img)->get();
        return view('admin.items.fullkits.edit', compact('fullkit','brands','colors','color_value','medias','index_img','media_remain','statuses'));
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
            return redirect()->route('fullkits.edit', [$id])
                        ->withErrors($validator)
                        ->withInput();
        }

        $input = $request->all();
        $fullkit = FullKit::findOrFail($id);
        $item = Item::findOrFail($fullkit->item_id);
        $item->name = $request->name;
        $item->description = $request->description;
        $item->summary = $request->summary;
        $item->price = $request->price;
        $item->price_off = $request->price_off;
        $item->item_status_id = $request->item_status_id;
        $item->save();

        if($request->homepage_active == "on")
        {
            $fullkit->homepage_active = 1;
        }
        else{
            $fullkit->homepage_active = 0;
        }
        
        $fullkit->brand_id = $request->brand_id;
        $fullkit->slug = Alpha::alpha_dash($item->name);
        $fullkit->save();
        if(isset($input['color_id']))
        {
            $fullkit->colors()->detach();
            foreach($input['color_id'] as $input_color)
            {
                $color = Color::findOrFail($input_color);
                if(in_array($input_color, $fullkit->colors->pluck('id')->all()))
                {
                    //echo "";
                }
                else
                {
                    $fullkit->colors()->save($color);
                }
            }
        }
        return redirect()->route('fullkits.edit',[$id])->with('status','Lưu chỉnh sửa thành công');
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
        $fullkit = FullKit::findOrFail($id);
        $item = Item::findOrFail($fullkit->item_id);
        $fullkit->colors()->detach();
        $fullkit->medias()->detach();
        $fullkit->delete();
        $item->delete();
        return redirect()->route('fullkits.index')->with('delete','Xóa full kit thành công!');
    }

    public function uploadImage(Request $request, $id)
    {
        //
        //dd($request->all());
        $files = $request->file('medias');
        $fullkit = FullKit::findOrFail($id);
        if($files === null)
        {
            return redirect()->route('fullkits.edit', [$id])->with('error','No input');
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
                    return redirect()->route('fullkits.edit', [$id])->with('error','Not a image file!');
                }
                if($media->id > 0)
                {
                    $fullkit->medias()->save($media);
                }
            }
        }

        //dd($fullkit->media);
        return redirect()->route('fullkits.edit', [$id])->with('status','Cập nhật image thành công');
    }

    public function selectImage(Request $request, $id)
    {
        $input = $request->all();
        $fullkit = FullKit::findOrFail($id);
        //dd($request->all());
        if($input['media_id'])
        {
            $fullkit->medias()->detach();
            foreach($input['media_id'] as $input_media)
            {
                $media = Media::findOrFail($input_media);
                if(in_array($input_media, $fullkit->medias->pluck('id')->all()))
                {
                    //echo "";
                }
                else
                {
                    $fullkit->medias()->save($media);
                }
            }
        }
        return redirect()->route('fullkits.edit', [$id])->with('status','Cập nhật image thành công');
    }

    public function set_image_index(Request $request, $id)
    {
        $input = $request->all();
        $fullkit = FullKit::findOrFail($id);
        //dd($input['media_id']);
        $fullkit->item->index_img = $input['media_id'];
        $fullkit->item->save();
        foreach ($fullkit->medias as $media) {
            if($media->id == $fullkit->item->index_img)
            {
                echo "found it";
            }
        }
        return redirect()->route('fullkits.edit', [$id])->with('status','Cập nhật ảnh đầu tiên thành công');
        //dd($fullkit->item);
    }

    public function delete_image(Request $request, $id)
    {
        $input = $request->all();
        $fullkit = FullKit::findOrFail($id);
        //dd($input['media_id']);
        //dd($fullkit->medias->where('id',$input['media_id'])->first());
        $media = $fullkit->medias->where('id',$input['media_id'])->first();

        $fullkit->medias()->detach($input['media_id']);
        unlink(public_path() . '/images/' . $media->file_name);
        $media->delete();
        return redirect()->route('fullkits.edit', [$id])->with('status','Xóa hình ảnh thành công');
    }
}
