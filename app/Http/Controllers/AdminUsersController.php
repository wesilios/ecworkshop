<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Http\Requests\AdminCreateRequest;
use Illuminate\Validation\Rule;
use App\Admin;
use App\Role;
use App\Photo;
use Auth;

class AdminUsersController extends Controller
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
        if(Auth::user()->id == 1)
        {
            $admins = Admin::all();
        }
        else{
            $admins = Admin::where('id', '>', '1')->get();
        }
        return view('admin.users.index', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $roles = Role::all()->pluck('name','id');
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminCreateRequest $request)
    {
        //
        
        $admin = new Admin;

        if($file = $request->file('photo_id')) {
            $name = time() . '_' . $file->getClientOriginalName();
            $file->move('images', $name);
            $photo = Photo::create(['path'=>$name]);
            $admin->photo_id = $photo->id;
        }

        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->password = bcrypt($request->password);
        $admin->role_id = $request->role_id;
        $admin->save();
        return redirect()->route('users.index')->with('status', 'Thêm tài khoản mới thành công!');
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
        $admin = Admin::findOrFail($id);
        $items = $admin->items()->orderBy('id', 'desc')->take(10)->get();
        $articles = $admin->articles()->orderBy('id', 'desc')->take(10)->get();
        return view('admin.users.show', compact('admin','items','articles'));
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
        
        $admin = Admin::findOrFail($id);
        $roles = Role::all()->pluck('name','id');
        //$roles = Role::where('id', '!=', $admin->id)->pluck('name','id');
        //$role = $roles->put($admin->role_id,$admin->role->name);
        //dd($role);
        return view('admin.users.edit', compact(['admin','roles']));
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
        $validator = Validator::make($request->all(), [
            'name'=> 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('admins')->ignore($id),
            ],
            'password' => 'required|string|min:6|confirmed',
            'role_id' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->route('users.edit', [$id])
                        ->withErrors($validator)
                        ->withInput();
        }

        $admin = Admin::findOrFail($id);

        if($file = $request->file('photo_id')) {
            $name = time() . '_' . $file->getClientOriginalName();
            $file->move('images', $name);
            $photo = Photo::create(['path'=>$name]);
            $admin->photo_id = $photo->id;
        }

        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->password = bcrypt($request->password);
        $admin->role_id = $request->role_id;
        $admin->save();
        return redirect()->route('users.show', [$id])->with('edit', 'Lưu chỉnh sửa thành công!');
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
    }
}
