<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            'name'=> 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admins',
            'password' => 'required|string|min:6',
            'role_id' => 'required'
        ];
    }

    public function messages()
    {
        return [

            'name.required' => 'Chưa nhập tên tài khoản',
            'email.required' => 'Chưa nhập email',
            'email.unique' => 'Email này đã được sử dụng',
            'password.required' => 'Chưa thiết lập mật khẩu',
            'password.min' => 'Password phải có 6 kí tự',
            'role_id.required' =>'Chưa chọn quyền tài khoản'
        ];
    }
}
