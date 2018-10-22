<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Size;
use Validator;
use Auth;

class AdminSizesController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
    	$juice_sizes = Size::orderBy('id', 'desc')->paginate(10);
    	return view('admin.juicesizes.index', compact('juice_sizes'));
    }

    public function store(Request $request)
    {
    	$validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:tank_categories'
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.juices.sizes.index')
                        ->withErrors($validator)
                        ->withInput();
        }

        $juice_size = new Size;
        $juice_size->name = $request->name;
        $juice_size->save();
        return redirect()->route('admin.juices.sizes.index')->with('status', 'Thêm loại tinh dầu mới thành công!');
    }

    public function update(Request $request, $id)
    {
    	$validator = Validator::make($request->all(), [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('juice_categories')->ignore($id),
            ]
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.juices.sizes.index')
                        ->withErrors($validator);
        }

        $juice_size = Size::findOrFail($id);
        $juice_size->update($request->all());
        return redirect()->route('admin.juices.sizes.index')->with('status','Lưu thành công!');
    }

    public function destroy($id)
    {
    	$juice_size = Size::findOrFail($id);
        $juice_size->delete();
        return redirect()->route('admin.juices.sizes.index')->with('delete','Xóa thành công!');
    }
}
