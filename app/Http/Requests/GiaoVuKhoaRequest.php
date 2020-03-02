<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GiaoVuKhoaRequest extends FormRequest
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
            'cbgv' => 'required',
            'khoa' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'cbgv.required' => 'Vui lòng chọn cán bộ - giảng viên',
            'khoa.required' => 'Vui lòng chọn khoa phụ trách'
        ];
    }
}
