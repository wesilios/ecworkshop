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
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
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
        $article->content = $request->content;
        $article->summary = $request->summary;
        $article->category_id = $request->category_id;
        $article->admin_id = Auth::user()->id;
        $article->slug = Alpha::alpha_dash($article->title);
        $article->save();
        //dd($input);

        if(isset($input['tag_id']))
        {
            foreach($input['tag_id'] as $input_tag)
            {
                $tag = Tag::findOrFail($input_tag);
                $article->tags()->save($tag);
            }
        }
        return redirect()->route('articles.index')->with('status','Thêm bài viết mới thành công');
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
        $medias = Media::orderBy('id', 'desc')->get();
        $article = Article::findOrFail($id);
        $tags = Tag::all()->pluck('name', 'id');
        $categories = Category::all()->pluck('name','id');
        $tag_value = $article->tags->pluck('id');
        $article_media = $article->media;
        return view('admin.articles.edit', compact('article','categories','tags','tag_value','medias'));
        
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
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'summary' => 'required|string',
            'category_id' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->route('articles.edit', [$id])
                        ->withErrors($validator)
                        ->withInput();
        }

        $input = $request->all();
        $article = Article::findOrFail($id);
        $article->title = $request->title;
        $article->content = $request->content;
        $article->summary = $request->summary;
        $article->category_id = $request->category_id;
        $article->save();
        //dd($input);
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
        //dd($request->all());
        $file = $request->file('medias');
        $article = Article::findOrFail($id);
        if($file === null)
        {
            return redirect()->route('articles.edit', [$id])->with('error','No input');
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
                return redirect()->route('articles.edit', [$id])->with('error','Not a image file!');
            }
        }

        if($media->id > 0)
        {
            $article->media()->sync($media);
        }
        //dd($article->media);
        return redirect()->route('articles.edit', [$id])->with('status','Cập nhật image thành công');
    }

    public function selectImage(Request $request, $id)
    {
        $input = $request->all();
        $article = Article::findOrFail($id);
        //dd($request->all());
        $media = Media::findOrFail($input['media_id']);
        $article->media()->sync($media);
        return redirect()->route('articles.edit', [$id])->with('status','Cập nhật image thành công');
    }
}
