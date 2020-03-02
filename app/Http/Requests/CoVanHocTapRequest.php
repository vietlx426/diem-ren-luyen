<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CoVanHocTapRequest extends FormRequest
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
            'lop' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'cbgv.required' => 'Vui lòng chọn cán bộ - giảng viên',
            'lop.required' => 'Vui lòng chọn lớp phụ trách'
        ];
    }
}
