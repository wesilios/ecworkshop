<?php

namespace App\Http\Controllers;

use App\ItemCategory;
use App\MenuDetail;
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

        $menu = Menu::find($id);
        $menu->update($request->all());
        return redirect()->route('admin.menus.index')->with('status','Lưu thành công!');
    }

    public function destroy($id)
    {
    	$menu = Menu::find($id);
        $menu->delete();
        return redirect()->route('admin.menus.index')->with('delete','Xóa thành công!');
    }

    public function edit(Request $rq, $id)
    {
        try {
            $menu = Menu::find($id);
            if($menu->menu_details->isEmpty()) {
                $pages = Page::all()->pluck('name','id');
                $item_parent = ItemCategory::all();
            } else {
                if($menu->menu_details()->where('type','page')->get()->isNotEmpty()){
                    $pages = '';
                    foreach($menu->menu_details()->where('type','page')->get() as $detail_page) {
                        if(empty($pages) || isset($pages)){
                            $pages = Page::where('id','!=', $detail_page->page_item_cat_id);
                        } else {
                            $pages = $pages->where('id','!=', $detail_page->page_item_cat_id);
                        }
                    }
                    $pages = $pages->get()->pluck('name','id');
                } else {
                    $pages = Page::all()->pluck('name','id');
                }
                if($menu->menu_details()->where('type','item_cat')->get()->isNotEmpty()) {
                    $item_parent = '';
                    foreach($menu->menu_details()->where('type','item_cat')->get() as $detail_item_cat) {
                        if(empty($item_parent) || isset($item_parent)) {
                            $item_parent = ItemCategory::where('id','!=',$detail_item_cat->page_item_cat_id);
                        } else {
                            $item_parent = $item_parent->where('id','!=',$detail_item_cat->page_item_cat_id);
                        }
                    }
                    $item_parent = $item_parent->get();
                } else {
                    $item_parent = ItemCategory::all();
                }
            }
            return view('admin.menus.edit', compact('menu','pages', 'item_parent'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function addPage(Request $rq, $id)
    {
        $menu = Menu::find($id);
        $page_id = $rq->get('page_id','');
        $item_cat_id = $rq->get('item_cat_id','');
        if(!empty($page_id)) {
            $page = Page::find($page_id);
            if($page) {
                $new_page = new MenuDetail();
                $new_page->menu_id = $menu->id;
                $new_page->type = 'page';
                $new_page->page_item_cat_id = $page_id;
                $new_page->order_no = $menu->menu_details->isNotEmpty() ? $menu->menu_details->count()+1 : 1;
                $new_page->save();
            }
        } elseif(!empty($item_cat_id)) {
            $item_cat = ItemCategory::find($item_cat_id);
            if($item_cat) {
                $new_page = new MenuDetail();
                $new_page->menu_id = $menu->id;
                $new_page->type = 'item_cat';
                $new_page->page_item_cat_id = $item_cat_id;
                $new_page->order_no = $menu->menu_details->isNotEmpty() ? $menu->menu_details->count()+1 : 1;
                $new_page->save();
            }
        }
        return redirect()->back()->with('status','Thêm trang vào menu thành công');
    }

    public function destroyPage($menu_id, $page_id)
    {
        try {
            $menu = Menu::find($menu_id);
            $page = MenuDetail::find($page_id);
            if($page) {
                $pages = MenuDetail::where([
                    ['menu_id','=',$menu_id],
                    ['order_no','>',$page->order_no]
                ])->get();
                foreach($pages as $p) {
                    $p->order_no = $p->order_no-1;
                    $p->save();
                }
                $page->delete();
            } else {
                return redirect()->back()->with('error','Trang không tìm thấy');
            }
            return redirect()->back()->with('delete','Xóa trang khỏi thành công');
        } catch (\Exception $e) {
            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    public function savePageOrder(Request $rq, $menu_id, $page_id)
    {
        try {
            $menu = Menu::find($menu_id);
            $page = MenuDetail::find($page_id);
            if($page) {
                $newPageOrder = $rq->get('pageOrder','');
                if(!empty($newPageOrder)) {
                    if($newPageOrder > 0 && $newPageOrder <= $menu->menu_details->count()) {
                        if($newPageOrder < $page->order_no) {
                            $pages = MenuDetail::where([
                                ['menu_id','=',$menu_id],
                                ['order_no','<',$page->order_no]
                            ])->get();
                            foreach($pages as $p) {
                                if($newPageOrder <= $p->order_no) {
                                    $p->order_no = $p->order_no+1;
                                    $p->save();
                                }
                            }
                        } elseif($newPageOrder > $page->order_no) {
                            $pages = MenuDetail::where([
                                ['menu_id','=',$menu_id],
                                ['order_no','>',$page->order_no]
                            ])->get();
                            foreach($pages as $p) {
                                if($newPageOrder >= $p->order_no) {
                                    $p->order_no = $p->order_no-1;
                                    $p->save();
                                }
                            }
                        }
                    } else {
                        return redirect()->back()->with('error','Thứ tự trang vượt quá số lượng trang trong menu');
                    }
                } else {
                    return redirect()->back()->with('error','Số thứ tự trang bị thiếu');
                }
                $page->order_no = $newPageOrder;
                $page->save();
                return redirect()->route('admin.menus.edit',[$menu_id])
                    ->with('status','Cập nhật menu thành công');
            } else {
                return redirect()->back()->with('error','Trang không tìm thấy');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error',$e->getMessage());
        }
    }
}
