<?php

namespace Modules\HocBong\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImportDSSVHBRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'input_file' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'input_file.required' => "Vui lòng chọn file excel chứa danh sách học bổng"
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
