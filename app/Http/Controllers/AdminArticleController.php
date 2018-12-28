<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use Validator;
use Auth;
use App\Article;
use App\Category;
use App\Tag;
use App\Alpha;
use App\Media;
use App\Folder;

class AdminArticleController extends Controller
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
        $articles = Article::orderBy('id', 'desc')->paginate(10);
        //dd($articles);
        return view('admin.articles.index', compact('articles'));
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
        $tags = Tag::all()->pluck('name', 'id');
        $categories = Category::all()->pluck('name','id');
        return view('admin.articles.create', compact('categories','tags','medias'));
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
        try {
            $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:255',
                'content_ar' => 'required|string',
                'summary' => 'required|string',
                'category_id' => 'required'
            ]);

            if ($validator->fails()) {
                return redirect()->route('articles.create')
                    ->withErrors($validator)
                    ->withInput();
            }
            $input = $request->all();
            $article = new Article;
            $article->title = $request->title;
            $article->content = $request->content_ar;
            $article->summary = $request->summary;
            $article->category_id = $request->category_id;
            $article->admin_id = Auth::user()->id;
            $article->slug = Alpha::alpha_dash($article->title);
            $article->save();

            if(isset($input['tag_id']))
            {
                foreach($input['tag_id'] as $input_tag)
                {
                    $tag = Tag::findOrFail($input_tag);
                    $article->tags()->save($tag);
                }
            }
            return redirect()->route('articles.index')->with('status','Thêm bài viết mới thành công');
        } catch (\Exception $e) {
            return redirect()->back()->with('status',$e->getMessage());
        }
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
        $article = Article::findOrFail($id);
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
        $article = Article::findOrFail($id);
        $medias = Media::where('folder_id','=','1');
        if($article->media->first())
        {
            $medias = $medias->where('id','!=',$article->media->first()->id);
        }
        $medias = $medias->orderBy('id', 'desc')->get();
        $folder = Folder::findOrFail(1);
        $folder_list = Folder::where('folder_id',$folder->id)->get();
        $new = ['folder_id' => $folder->id,'folder_name' => $folder->name, 'folder_slug'=>$folder->slug];
        $folder_string[] = $new;
        $tags = Tag::all()->pluck('name', 'id');
        $categories = Category::all()->pluck('name','id');
        $tag_value = $article->tags->pluck('id');
        $article_media = $article->media;
        return view('admin.articles.edit', compact('article','categories','tags','tag_value','medias','folder_list','folder_string','folder'));
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
            'title' => 'required|string|max:255',
            'content_ar' => 'required|string',
            'summary' => 'required|string',
            'category_id' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->route('articles.edit', [$id])
                        ->withErrors($validator)
                        ->withInput();
        }

        $input = $request->all();
        $article = Article::find($id);
        $article->title = $request->title;
        $article->content = $request->content_ar;
        $article->summary = $request->summary;
        $article->category_id = $request->category_id;
        $article->save();
        if($input['tag_id'])
        {
            foreach($input['tag_id'] as $input_tag)
            {
                $tag = Tag::findOrFail($input_tag);
                if(in_array($input_tag, $article->tags->pluck('id')->all()))
                {
                    //echo "";
                }
                else
                {
                    $article->tags()->save($tag);
                }
            }
        }
        return redirect()->route('articles.edit', [$id])->with('status','Cập nhật bài viết thành công');
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
        $article = Article::findOrFail($id);
        $article->tags()->detach();
        $article->media()->detach();
        $article->delete();
        return redirect()->route('articles.index')->with('delete','Xóa bài viết thành công!');
    }

    public function uploadImage(Request $request, $id)
    {
        //
        $file = $request->file('medias');
        $article = Article::findOrFail($id);
        if($file === null)
        {
            return redirect()->route('articles.edit', [$id])->with('error','No input');
        }
        else
        {
            $file->getClientMimeType();
            if(substr($file->getMimeType(), 0, 5) == 'image') {
                $name = time() . '_media_' . $file->getClientOriginalName();
                $type = $file->getMimeType();
                $file->move('images', $name);
                $admin_id = Auth::user()->id;
                $media = Media::create(['file_name'=>$name, 'url'=>$name, 'type'=>$type, 'admin_id'=>$admin_id]);
            }
            else
            {
                return redirect()->route('articles.edit', [$id])->with('error','Not a image file!');
            }
        }

        if($media->id > 0)
        {
            $article->media()->sync($media);
        }
        return redirect()->route('articles.edit', [$id])->with('status','Cập nhật image thành công');
    }

    public function selectImage(Request $request, $id)
    {
        $input = $request->all();
        $article = Article::findOrFail($id);
        $media = Media::findOrFail($input['media_id']);
        $article->media()->sync($media);
        return redirect()->route('articles.edit', [$id])->with('status','Cập nhật image thành công');
    }

    public function ajaxUpload(Request $request)
    {
        if($request->ajax())
        {
            $file      = $request->file('medias');
            $folder    = Folder::find($request->folder_id);
            $article   = Article::find($request->article_id);
            $folder_id = $folder->id;

            if($file === null)
            {
                return response()->json([
                    'error'   => '1',
                    'message' => 'File is empty',
                ]);
            }
            $file = Media::ajaxUploadImage($file, $folder_id);
            if(!empty($file))
            {
                $medias = Media::where('folder_id', '=', $folder_id)->orderBy('id', 'desc')->get();
                $data   = view('admin.ajax.media.new_files', compact('medias', 'folder', 'article'))->render();
                return response()->json([
                    'data'        => $data,
                    'file'        => $file,
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
}
