<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KhoaHocRequest extends FormRequest
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
        $rules = [
            'tenkhoahoc' => 'required',
            'bacdaotao' => 'required',
            'nambatdau' => 'required',
            'namketthuc' => 'required'
        ];

        $namBatDau = ($this::input('nambatdau'));
        $namKetThuc = ($this::input('namketthuc'));
        
        if($this::input('nambatdau') && $this::input('namketthuc') && ($namKetThuc < $namBatDau ))
        {
            $rules['namketthuc'] = 'alpha';
        }

        return $rules;

    }

    public function messages()
    {
        return [
            'tenkhoahoc.required' => 'Vui lòng nhập tên khóa học',
            'bacdaotao.required' => 'Vui lòng chọn bậc đào tạo',
            'nambatdau.required' => 'Vui lòng nhập năm bắt đầu',
            'namketthuc.required' => 'Vui lòng nhập năm kết thúc',
            'namketthuc.alpha' => 'Năm kết thúc không được nhỏ hơn năm bắt đầu'
        ];
    }
}
