<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TieuChiRequest extends FormRequest
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
            'noidungtieuchi'=>'required',
            'loaidiem'=>'required',
            'diemtoida'=>'required'
            // 'trangthai'=>'required'
        ];
    }

    public function messages()
    {
        return [
            'noidungtieuchi.required'=>'Vui lòng nhập nội dung tiêu chí',
            'loaidiem.required'=>'Vui lòng chọn loại điểm',
            'diemtoida.required'=>'Vui lòng nhập điểm tối đa'
            // 'trangthai.required'=>'Vui lòng chọn trạng thái tiêu chí'
        ];
    }

}
