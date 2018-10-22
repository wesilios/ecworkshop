<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRegisterRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:customers',
            'phonenumber' => 'required|numeric|unique:customers',
            'password' => 'required|string|min:6'
        ];
    }

    public function messages()
    {
        return [

            'name.required' => 'Bạn phải nhập tên tài khoản',
            'email.required' => 'Bạn phải nhập email',
            'email.unique' => 'Email này đã được sử dụng',
            'phonenumber.required' => 'Bạn phải nhập số điện thoại',
            'phonenumber.numeric' => 'Số điện thoại không được có chữ cái',
            'password.required' => 'Chưa thiết lập mật khẩu',
            'password.min' => 'Password phải có 6 kí tự trở lên'
        ];
    }
}
