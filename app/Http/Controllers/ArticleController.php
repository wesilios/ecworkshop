<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;
use App\Setting;
use App\Menu;
use App\Page;

class ArticleController extends Controller
{
    //
    public function getArticles()
    {
        $settings = Setting::findOrFail(1);
        $footer_1st_menu = Menu::where('id',2)->first();
        $footer_2nd_menu = Menu::where('id',3)->first();
        $top_nav = Menu::where('id',1)->first();
        $page = Page::where('slug','=','review-blog')->first();
        $articles = Article::where('category_id','>','1')->paginate(12);
        return view('mainsite.articles', compact('articles','settings','footer_1st_menu','footer_2nd_menu','top_nav','page'));
    }
    
    public function getSingle($slug)
    {
    	$settings = Setting::findOrFail(1);
        $footer_1st_menu = Menu::where('id',2)->first();
        $footer_2nd_menu = Menu::where('id',3)->first();
        $top_nav = Menu::where('id',1)->first();
        $page = Page::where('slug','=','review-blog')->first();
    	$article = Article::where('slug','=', $slug)->first();
        $random_articles = Article::where('id', '!=', $article->id)->
                where(function ($query) {
                    $query->where('category_id','>',1);
                    })->inRandomOrder()->take(4)->get();
    	return view('mainsite.article', compact(
            'article',
            'settings',
            'footer_1st_menu',
            'footer_2nd_menu',
            'top_nav',
            'page',
            'random_articles'
        ));
    }
}
