<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestScholarship extends FormRequest
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
            'mahb'=>'required|unique:hocbong,mahb,'.$this->id,
            'tenhb'=>'required',
            'tendvtt'=>'required',
            'soluong'=>'required',
            'idhockynamhoc'=>'required',
            'gthb'=>'required|numeric|min:0|not_in:0',

            'soluong'=>'required|numeric|min:0|not_in:0',
            'gtmoihocbong'=>'required|numeric|min:0|not_in:0',

        ];
    }
    public function messages(){
        return [
            'mahb.required'=>'Vui lòng điền mã học bổng',
            'mahb.unique'=>'Mã học bổng đã tồn tại',
            'tenhb.required'=>'Vui lòng tên học bổng',
            'tendvtt.required'=>'Vui lòng điền đơn vị tài trợ',
            'soluong.required'=>'Vui lòng nhập số lượng',
            'gthb.required'=>'Vui lòng nhập giá trị học bổng',
            'gthb.not_in'=>'Giá trị học bổng phải lớn hơn 0',
            'gthb.min'=>'Giá trị học bổng phải lớn hơn 0',
            'soluong.required'=>'Vui lòng nhập số lượng',
            'soluong.not_in'=>'Số lượng phải lớn hơn 0',
            'soluong.min'=>'Số lượng phải lớn hơn 0',
            'idhockynamhoc.required'=>'Vui lòng chọn học kỳ, năm học',
            
            'gtmoihocbong.required'=>'Vui lòng nhập giá trị mỗi học bổng',
            'gtmoihocbong.not_in'=>'Giá trị mỗi học bổng phải lớn hơn 0',
            'gtmoihocbong.min'=>'Giá trị mỗi học bổng phải lớn hơn 0',

            
        ];
    }
}
