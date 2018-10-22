<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Menu;
use App\Page;
use Validator;
use Auth;

class AdminMenusController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
    	$menus = Menu::orderBy('id', 'desc')->paginate(10);
    	return view('admin.menus.index', compact('menus'));
    }

    public function store(Request $request)
    {
    	$validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.juices.cat.index')
                        ->withErrors($validator)
                        ->withInput();
        }

        $menu = new Menu;
        $menu->name = $request->name;
        $menu->save();
        return redirect()->route('admin.menus.index')->with('status', 'Thêm menu mới thành công!');
    }

    public function update(Request $request, $id)
    {
    	$validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.menus.index')
                        ->withErrors($validator);
        }

        $menu = Menu::findOrFail($id);
        $menu->update($request->all());
        return redirect()->route('admin.menus.index')->with('status','Lưu thành công!');
    }

    public function destroy($id)
    {
    	$menu = Menu::findOrFail($id);
        $menu->delete();
        return redirect()->route('admin.menus.index')->with('delete','Xóa thành công!');
    }

    public function edit($id)
    {
        $menu = Menu::findOrFail($id);
        $pages = Page::all()->pluck('name','id');
        return view('admin.menus.edit', compact('menu','pages'));
    }

    public function addPage(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);
        //dd($request->all());
        $page = Page::findOrFail($request->page_id);
        //dd($page);
        foreach($menu->pages as $pagelist)
        {
            if($pagelist->pivot->page_id == $request->page_id)
            {
                return redirect()->route('admin.menus.edit',[$id])->with('error','Trang này đã có trên menu');
            }
        }
        $menu->pages()->attach($page);
        return redirect()->route('admin.menus.edit',[$id])->with('status','Thêm trang vào menu thành công');
    }

    public function destroyPage($menu_id, $page_id)
    {
        $menu = Menu::findOrFail($menu_id);
        //dd($request->all());
        $page = Page::findOrFail($page_id);
        $menu->pages()->detach($page);
        return redirect()->route('admin.menus.edit',[$menu_id])->with('delete','Xóa trang khỏi thành công');
    }

    public function savePageOrder(Request $request, $menu_id, $page_id)
    {
        //dd($request->all());
        $menu = Menu::findOrFail($menu_id);
        $page = Page::findOrFail($page_id);
        
        return redirect()->route('admin.menus.edit',[$menu_id])->with('status','Cập nhật menu thành công');
    }
}
