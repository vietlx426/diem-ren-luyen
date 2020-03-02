<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CanBoGiangVienRequest extends FormRequest
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
            'macanbogiangvien' => 'required',
            'hochulot' => 'required',
            'ten' => 'required',
            'gioitinh' => 'required',
            'email' => 'required|email',
            'bomonto' => 'required',
            // 'bophancongtac' => 'required',
            'loaicbgv' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'macanbogiangvien.required' => 'Vui lòng nhập mã cán bộ-giảng viên',
            'hochulot.required' => 'Vui lòng nhập họ và chữa lót',
            'ten.required' => 'Vui lòng nhập tên',
            'gioitinh.required' => 'Vui chọn giới tính',
            'email.required' => 'Vui nhập email',
            'email.email' => 'Email không đúng định dạng',
            'bomonto.required' => 'Vui chọn bộ môn/tổ',
            'bophancongtac.required' => 'Vui nhập bộ phận công tác',
            'loaicbgv.required' => 'Vui chọn giảng viên hay cán bộ phòng ban',
        ];
    }
}
