<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestAwardScholarship extends FormRequest
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
            'idhocbong'=>'required',
            'giatri'=>'required',
        ];
    }
    public function messages(){
        return [
            'idhocbong.required'=>'Vui lòng chọn học bổng',
        
            'giatri.required'=>'Vui lòng nhập giá trị học bổng',
            
            
            
        ];
    }
}
