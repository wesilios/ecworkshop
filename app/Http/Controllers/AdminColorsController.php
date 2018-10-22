<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Color;
use Validator;
use Auth;

class AdminColorsController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
    	$colors = Color::orderBy('id', 'desc')->paginate(10);
    	return view('admin.colors.index', compact('colors'));
    }

    public function store(Request $request)
    {
    	$validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:colors'
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.colors.index')
                        ->withErrors($validator)
                        ->withInput();
        }

        $color = new Color;
        $color->name = $request->name;
        $color->save();
        return redirect()->route('admin.colors.index')->with('status', 'Thêm màu mới thành công!');
    }

    public function update(Request $request, $id)
    {
        //
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('colors')->ignore($id),
            ]
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.colors.index')
                        ->withErrors($validator);
        }

        $color = Color::findOrFail($id);
        $color->update($request->all());
        return redirect()->route('admin.colors.index')->with('status','Lưu thành công!');
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
        $color = Color::findOrFail($id);
        $color->delete();
        return redirect()->route('admin.colors.index')->with('delete','Xóa thành công!');
    }
}
