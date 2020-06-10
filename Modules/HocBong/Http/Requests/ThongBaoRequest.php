<?php

namespace Modules\HocBong\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ThongBaoRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'tieude'=>'required|unique:hocbong_thongbao,tieude,'.$this->id,
            'noidung'=>'required',
            'hocbong'=>'required',
            
        ];
    }
    public function messages(){
        return [
            'tieude.unique'=>'Tên thông báo đã tồn tại',
            'tieude.required'=>'Nhập tên tiêu đề',
            'noidung.required'=>'Nhập nội dung thông báo',
            'hocbong.required'=>'Chọn học bổng',      
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
