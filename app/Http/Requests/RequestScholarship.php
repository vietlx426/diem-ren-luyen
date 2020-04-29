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
            'gthb'=>'required',
            
        ];
    }
    public function messages(){
        return [
            'mahb.required'=>'Vui lòng điền mã học bổng',
            'mahb.unique'=>'Mã học bổng đã tồn tại',
            'tenhb.required'=>'Vui lòng tên học bổng',
            'tendvtt.required'=>'Vui lòng điền đơn vị tài trợ',
            'soluong.required'=>'Vui lòng nhập số lượng',
            'idhockynamhoc.required'=>'Vui lòng nhập số lượng',

            
        ];
    }
}
