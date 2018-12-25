<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Setting;

class AdminSettingsController extends Controller
{
    //
	public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function edit($id)
    {
    	$settings = Setting::findOrFail($id);
    	return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request, $id)
    {
    	$validator = Validator::make($request->all(), [
            'address' => 'required|string|max:255',
            'facebook' => 'required|string|max:255',
            'phone' => 'string|max:255',
            'work_hour' => 'string|max:255',
            'youtube' => 'string|max:255',
            'instagram' => 'string|max:255',
            'google_id' => 'nullable|string',
            'fb_pixel' => 'nullable|string',
            'description' => 'string',
            'webmaster' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.settings.edit', [$id])
                        ->withErrors($validator)
                        ->withInput();
        }

        $settings = Setting::findOrFail($id);
        $settings->update($request->all());

        //dd($request->all());
        return redirect()->route('admin.settings.edit', [$id])->with('settings', 'Lưu chỉnh sửa thành công!');
    }
}
