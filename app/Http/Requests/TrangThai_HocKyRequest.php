<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TrangThai_HocKyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // return false;
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
            'TenTrangThaiHocKy' => 'required',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            // 'TenTrangThaiHocKy.required' => 'Vui lòng nhập tên trạng thái.',
        ];
    }
}
