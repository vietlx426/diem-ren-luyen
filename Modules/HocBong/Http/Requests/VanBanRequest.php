<?php

namespace Modules\HocBong\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VanBanRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'DinhKem'=>'required',
        ];
    }
    public function messages(){
        return [
          
            'DinhKem.required'=>'Nhập tên tiêu đề',
            
            

            
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
