<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use Validator;
use Auth;
use App\Page;
use App\Alpha;
use App\Media;

class AdminPagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        //
        $pages = Page::orderBy('id', 'desc')->paginate(10);
        return view('admin.pages.index', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        //Auth::user()->id;
        $medias = Media::all();
        $pages = Page::whereNull ('page_id')->pluck('name','id');
        return view('admin.pages.create', compact('medias','pages'));
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
            'description' => 'required|string'
        ]);

        if ($validator->fails()) {
            return redirect()->route('pages.create')
                        ->withErrors($validator)
                        ->withInput();
        }
        $input = $request->all();
        $page = new Page;
        $page->name = $request->name;
        $page->description = $request->description;
        $page->content = $request->content_page;
        $page->admin_id = Auth::user()->id;
        $page->slug = Alpha::alpha_dash($page->name);
        $page->page_id = $request->page_id;
        $page->save();
        //dd($input);

        return redirect()->route('pages.index')->with('status','Thêm bài viết mới thành công');
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
        $page = Page::findOrFail($id);
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
        $page = Page::findOrFail($id);
        $pages = Page::whereNull ('page_id')->pluck('name','id');
        $article_media = $page->media;
        return view('admin.pages.edit', compact('page','medias','pages'));

        //dd($tags);

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
            'description' => 'required|string'
        ]);

        if ($validator->fails()) {
            return redirect()->route('pages.edit', [$id])
                        ->withErrors($validator)
                        ->withInput();
        }

        $input = $request->all();
        $page = Page::findOrFail($id);
        $page->name = $request->name;
        $page->description = $request->description;
        $page->content = $request->content_page;
        $page->page_id = $request->page_id;
        $page->slug = Alpha::alpha_dash($page->name);
        $page->save();
        return redirect()->route('pages.edit', [$id])->with('status','Cập nhật trang thành công');
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
        $page = Page::findOrFail($id);
        $page->media()->detach();
        $page->delete();
        return redirect()->route('pages.index')->with('delete','Xóa bài viết thành công!');
    }

    public function uploadImage(Request $request, $id)
    {
        //
        $file = $request->file('medias');
        $page = Page::findOrFail($id);
        if($file === null)
        {
            return redirect()->route('pages.edit', [$id])->with('error','No input');
        }
        else
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
                return redirect()->route('pages.edit', [$id])->with('error','Not a image file!');
            }
        }

        if($media->id > 0)
        {
            $page->media()->sync($media);
        }
        return redirect()->route('pages.edit', [$id])->with('status','Cập nhật image thành công');
    }

    public function selectImage(Request $request, $id)
    {
        $input = $request->all();
        $page = Page::findOrFail($id);
        $media = Media::findOrFail($input['media_id']);
        $page->media()->sync($media);
        return redirect()->route('pages.edit', [$id])->with('status','Cập nhật image thành công');
    }
}
