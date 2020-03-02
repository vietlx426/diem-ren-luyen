<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SinhVienRequest extends FormRequest
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
            'mssv' => 'required|between:9,9',
            'hochulot' => 'required',
            'ten' => 'required',
            'gioitinh' => 'required',
            'ngaysinh' => 'required|date_format:"Y-m-d"',
            'email' => 'required|email',
            'cmnd' => 'required|numeric',
            'lop' => 'required',
            'diemtrungtuyen' => 'required|numeric|min:0'
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
            'mssv.required' => 'Nhập mã số sinh viên',
            'mssv.between' => 'Mã số sinh viên gồm ký 9 tự',
            'hochulot.required' => 'Nhập họ và chữ lót',
            'ten.required' => 'Nhập tên',
            'gioitinh.required' => 'Chọn giới tính',
            'ngaysinh.required' => 'Nhập ngày sinh',
            'ngaysinh.date_format' => 'Giá trị không đúng định dạng (dd/mm/yyyy)',
            'email.required' => 'Nhập địa chỉ email',
            'email.email' => 'Không đúng định dạng email',
            'cmnd.required' => 'Nhập số chứng mình nhân dân',
            'cmnd.numeric' => 'Số chứng mình nhân dân chỉ chứa số',
            'lop.required' => 'Chọn lớp',
            'diemtrungtuyen.required' => 'Nhập điểm trúng tuyển',
            'diemtrungtuyen.numeric' => 'Giá trị phải là số',
            'diemtrungtuyen.min' => 'Giá trị không được nhỏ hơn 0',
        ];
    }
}
