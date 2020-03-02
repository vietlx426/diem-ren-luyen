<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TieuChiMinhChungRequest extends FormRequest
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
            'tenminhchung'=>'required',
            // 'diem'=>'required',
            'input_file'=>'required'
        ];
    }

    public function messages()
    {
        return [
            'tenminhchung.required'=>'Vui lòng nhập tên (mô tả) minh chứng',
            // 'diem.required'=>'Vui lòng nhập điểm',
            'input_file.required'=>'Vui lòng chọn danh sách để import'
        ];
    }
}
