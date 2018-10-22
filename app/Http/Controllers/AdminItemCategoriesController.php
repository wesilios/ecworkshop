<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\ItemCategory;
use App\Alpha;
use Validator;
use Auth;

class AdminItemCategoriesController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
    	$item_cats = ItemCategory::orderBy('id', 'desc')->paginate(15);
        $item_cats_parent = ItemCategory::where('item_category_id','<=',0)->get()->pluck('name','id');
    	return view('admin.items.categories.index', compact('item_cats','item_cats_parent'));
    }

    public function store(Request $request)
    {
    	$validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:item_categories'
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.items.cat.index')
                        ->withErrors($validator)
                        ->withInput();
        }

        $item_cat = new ItemCategory;
        $item_cat->name = $request->name;
        $item_cat->slug = Alpha::alpha_dash($request->name);
        $item_cat->save();
        return redirect()->route('admin.items.cat.index')->with('status', 'Thêm loại phụ kiện mới thành công!');
    }

    public function update(Request $request, $id)
    {
    	$validator = Validator::make($request->all(), [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('item_categories')->ignore($id),
            ]
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.items.cat.index')
                        ->withErrors($validator);
        }

        $item_cat = ItemCategory::findOrFail($id);
        $item_cat->slug = Alpha::alpha_dash($request->name);
        $item_cat->update($request->all());
        return redirect()->route('admin.items.cat.index')->with('status','Lưu thành công!');
    }

    public function destroy($id)
    {
    	$item_cat = ItemCategory::findOrFail($id);
        $item_cat->delete();
        return redirect()->route('admin.items.cat.index')->with('delete','Xóa thành công!');
    }

    public function updateItemCatsParent(Request $request, $id)
    {
        //dd($request->all());
        if($request->item_category_id == 0)
        {
            return redirect()->route('admin.items.cat.index')->with('error','Loại sản phẩm cha phải được chọn!');
        }
        $item_cat = ItemCategory::findOrFail($id);
        $item_cat->item_category_id = $request->item_category_id;
        $item_cat->save();
        return redirect()->route('admin.items.cat.index')->with('status','Lưu loại sản phẩm cha thành công!');
    }
}