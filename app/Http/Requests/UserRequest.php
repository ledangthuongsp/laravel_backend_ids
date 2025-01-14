<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class UserRequest extends FormRequest {

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:App\Models\User,name,' . $this->route('user'),
            'email' => 'required|email|unique:App\Models\User,email,' . $this->route('user'), 
            // $this->route('user'): lấy tham số từ URL với giá trị là ID của bản ghi hiện tại, chương trình sẽ bỏ qua so sánh với bản ghi có ID này 
            'password' => 'nullable|string|min:8|confirmed',
            'avatar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'avatar.image' => __('validation.avatar.image'),
            'avatar.max' => __('validation.avatar.max'),
            'name.required' => __('validation.name.required'),
            'name.unique' => __('validation.name.unique'),
            'name.max' => __('validation.name.max'),
            'email.required' => __('validation.email.required'),
            'email.unique' => __('validation.email.unique'),
            'email.email' => __('validation.email.email'),
            'password.nullable' => __('validation.password.nullable'),
            'password.min' => __('validation.password.min'),
            'password.confirmed' => __('validation.password.confirmed'),
        ];
    }
}