<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Fee;
use App\FeeDistrict;

class AdminFeesController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $citys = Fee::paginate(15);
        //dd($citys);
        return view('admin.fees.index', compact('citys'));
    }

    public function store(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.fee.edit', [$id])
                        ->withErrors($validator)
                        ->withInput();
        }
        $district = new FeeDistrict;
        $district->name = $request->name;
        $district->fee_id = $id;
        $district->save();
        return redirect()->route('admin.fee.edit', [$id])->with('district', 'Thêm quận huyện thành công');
    }

    public function edit($id)
    {
    	$fee = Fee::findOrFail($id);
    	return view('admin.fees.edit', compact('fee'));
    }

    public function update(Request $request, $id)
    {
    	//dd($request->all());
        $fee = Fee::findOrFail($id);
        $fee->update($request->all());
        return redirect()->route('admin.fee.edit', [$id])->with('feesetting', 'Cập nhật phí thành công');
    }

    public function updateDistrict(Request $request, $fee_id, $id)
    {
        //dd($request->all());
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.fee.edit', [$fee_id])
                        ->withErrors($validator)
                        ->withInput();
        }

        $district = FeeDistrict::findOrFail($id);
        $district->update($request->all());
        return redirect()->route('admin.fee.edit', [$fee_id])->with('feesetting', 'Cập nhật quận huyện thành công');
    }

    public function destroy($id)
    {

    }
}
