<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HocKyNamHocBoTieuChiRequest extends FormRequest
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
            'botieuchi' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'botieuchi.required' => "Vui lòng chọn bộ tiêu chí"
        ];
    }
}
