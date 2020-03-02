<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceImportSinhVienRequest extends FormRequest
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
            // 'lop' => 'required',
            'input_file' => 'required'
        ];
    }

    public function messages()
    {
        return [
            // 'lop.required' => "Vui lòng chọn lớp",
            'input_file.required' => "Vui lòng chọn file excel chứa danh sách sinh viên"
        ];
    }
}
