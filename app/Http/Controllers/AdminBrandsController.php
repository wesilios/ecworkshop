<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Auth;
use App\Brand;

class AdminBrandsController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        //
        $brands = Brand::orderBy('id', 'desc')->paginate(20);
        //dd($articles);
        return view('admin.brands.index', compact('brands'));
    }

    public function store(Request $request)
    {
    	$validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return redirect()->route('tags.index')
                        ->withErrors($validator)
                        ->withInput();
        }

        $brand = new Brand;
        $brand->name = $request->name;
        $brand->save();
        return redirect()->route('admin.brands.index')->with('status', 'Thêm hãng sản phẩm mới thành công!');
    }

    public function update(Request $request, $id)
    {
        //
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('brands')->ignore($id),
            ]
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.brands.index')
                        ->withErrors($validator);
        }

        $color = Brand::findOrFail($id);
        $color->update($request->all());
        return redirect()->route('admin.brands.index')->with('status','Lưu thành công!');
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
        $color = Brand::findOrFail($id);
        $color->delete();
        return redirect()->route('admin.brands.index')->with('delete','Xóa thành công!');
    }
}
