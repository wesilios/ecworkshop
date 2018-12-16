<?php

namespace App\Http\Controllers;

use App\ItemCategory;
use Illuminate\Http\Request;
use App\Item;
use App\ItemStatus;
use App\Brand;
use App\Media;
use App\Folder;

class AdminItemsController extends Controller
{
    //
    protected $item;
    protected $item_category;

    public function __construct(Item $item, ItemCategory $item_category)
    {
        $this->item = $item;
        $this->item_category = $item_category;
        $this->middleware('auth:admin');
    }

    public function index(Request $rq)
    {
        try {
            $slug = $rq->get('item_category');
            if($slug) {
                $item_category = ItemCategory::where('slug','=',$slug)->first();
                if($item_category->itemCategories->isNotEmpty())
                {
                    $items = Item::where('item_category_parent_id','=',$item_category->id)->paginate(10);//->paginate(10);
                } else {
                    $items = Item::where('item_category_id','=',$item_category->id)->paginate(10);//->paginate(10);
                }
                if($items->count() > 0)
                {
                    return view('admin.items.index',[
                        'items'             => $items,
                        'item_category'     => $item_category,
                        'title'             => $item_category->name,
                    ]);
                }
            } else {
                return '';
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function create(Request $rq, $slug)
    {
        try {

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function store(Request $rq, $slug)
    {
        try {

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function edit(Request $rq, $slug)
    {
        try {
            $item_slug = $slug;
            $item_category_slug = $rq->get('item_category');
            if($item_slug && $item_category_slug)
            {
                $brands = Brand::all()->pluck('name','id');
                $statuses = ItemStatus::all()->pluck('name','id');
                $medias = Media::where('folder_id','=','1');
                $medias = $medias->orderBy('id', 'desc')->get();
                $folder = Folder::findOrFail(1);
                $folder_list = Folder::where('folder_id',$folder->id)->get();
                $new = ['folder_id' => $folder->id,'folder_name' => $folder->name, 'folder_slug'=>$folder->slug];
                $folder_string[] = $new;
                $item_category = ItemCategory::where('slug','=',$item_category_slug)->first();
                if($item_category->item_category_id > 0 || $item_category->item_category_id != 0){
                    $item = Item::where('slug','=',$slug)->where('item_category_parent_id','=',$item_category->id)->first();
                } else {
                    $item = Item::where('slug','=',$slug)->where('item_category_id','=',$item_category->id)->first();
                }
                $index_img = null;
                foreach ($item->medias as $media) {
                    if($media->id == $item->index_img)
                    {
                        $index_img = $media;
                    }
                }
                $media_remain = $item->medias()->where('media_id','!=',  $item->index_img)->get();
                if(!empty($item))
                {
                    return view('admin.items.edit', [
                        'item'                  => $item,
                        'title'                 => $item->item_category_parent_id > 0 ? $item->itemCategoryParent ->name : $item->itemCategoryMain->name,
                        'item_category_slug'    => $item_category_slug,
                        'brands'                => $brands,
                        'item_category'         => $item_category,
                        'statuses'              => $statuses,
                        'medias'                => $medias,
                        'folder'                => $folder,
                        'folder_list'           => $folder_list,
                        'folder_string'         => $folder_string,
                        'index_img'             => $index_img,
                        'media_remain'          => $media_remain
                    ]);
                }
                return '';
            } else {
                return '';
            }
        } catch (\Exception $e){
            return $e->getMessage();
        }
    }

    public function update(Request $rq, $slug)
    {
        try {
            dd($slug);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function destroy(Request $rq, $slug)
    {
        try {
            $item = Item::where('slug','=',$slug)->first();
            $item_catgegory = ItemCategory::where('slug','=',$rq->item_category)->first();
            if($item && $item_catgegory)
            {
//                $item->detach();
                return redirect()->route('admin.items.index',['item_category'=>$rq->item_category])->with('delete','Xóa '. strtolower($item_catgegory->name) .' thành công!');
            } else {
                return '';
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function uploadImage(Request $request, $id)
    {
        //
        //dd($request->all());
        $files = $request->file('medias');
        $item = Item::findOrFail($id);
        if($files === null)
        {
            return redirect()->route('admin.items.edit', [$id])->with('error','No input');
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
                    return redirect()->route('admin.items.edit', [$id])->with('error','Not a image file!');
                }
                if($media->id > 0)
                {
                    $item->medias()->save($media);
                }
            }
        }

        //dd($item->media);
        return redirect()->route('admin.items.edit', [$id])->with('status','Cập nhật image thành công');
    }

    public function selectImage(Request $request, $slug)
    {
        $input = $request->all();
        $item = Item::where('slug','=',$slug)->first();
        if($request->get('media_id'))
        {
            $item->medias()->detach();
            foreach($input['media_id'] as $input_media)
            {
                $media = Media::findOrFail($input_media);
                if(in_array($input_media, $item->medias->pluck('id')->all()))
                {
                    //echo "";
                }
                else
                {
                    $item->medias()->save($media);
                }
            }
            return redirect()->route('admin.items.edit', ['slug'=>$slug,'item_category'=>$request->item_category])->with('status','Cập nhật image thành công');
        } else {
            return redirect()->route('admin.items.edit', ['slug'=>$slug,'item_category'=>$request->item_category])->with('status','Vui lòng chọn ảnh cần cập nhật');
        }
    }

    public function set_image_index(Request $request, $id)
    {
        $input = $request->all();
        $item = Item::findOrFail($id);
        $item->item->index_img = $input['media_id'];
        $item->item->save();
        foreach ($item->medias as $media) {
            if($media->id == $item->item->index_img)
            {
                echo "found it";
            }
        }
        return redirect()->route('admin.items.edit', [$id])->with('status','Cập nhật ảnh đầu tiên thành công');
        //dd($item->item);
    }

    public function delete_image(Request $request, $id)
    {
        $input = $request->all();
        $item = Item::findOrFail($id);
        //dd($input['media_id']);
        //dd($item->medias->where('id',$input['media_id'])->first());
        $media = $item->medias->where('id',$input['media_id'])->first();

        $item->medias()->detach($input['media_id']);
        unlink(public_path() . '/images/' . $media->file_name);
        $media->delete();
        return redirect()->route('admin.items.edit', [$id])->with('status','Xóa hình ảnh thành công');
    }

    public function ajaxUpload(Request $request)
    {
        if($request->ajax())
        {
            $files      = $request->file('medias');
            $folder     = Folder::find($request->folder_id);
            $item       = Item::find($request->item_id);
            $folder_id  = $folder->id;

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
                $data   = view('admin.ajax.media.items.new_files', compact('medias', 'folder', 'item'))->render();
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
            $item     = Item::find($request->item_id);
            $media = $item->medias->where('id',$request->media_id)->first();

            $item->medias()->detach($request->media_id);
            $index_img = '';
            foreach ($item->medias as $media) {
                if($media->id == $item->item->index_img)
                {
                    $index_img = $media;
                }
            }
            $media_remain = $item->medias()->where('media_id','!=',  $item->item->index_img)->get();
            $item     = Item::find($request->item_id);
            if($item->medias->isNotEmpty())
            {
                $data = view('admin.ajax.media.items.new_media_list', compact('item','index_img', 'media_remain'))->render();
                return response()->json([
                    'data'      => $data,
                    'item'      => $item->medias,
                    'success'   => '1',
                    'message'   => 'Sucess'
                ]);
            } else {
                $data = view('admin.ajax.media.items.new_media_list', compact('item','index_img', 'media_remain'))->render();
                return response()->json([
                    'data'      => $data,
                    'item'      => $item->medias,
                    'error'     => '1',
                    'message'   => 'Slider images for this item is empty'
                ]);
            }
        }
    }
}
