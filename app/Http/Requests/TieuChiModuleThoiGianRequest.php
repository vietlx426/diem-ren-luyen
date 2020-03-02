<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use DateTime;

class TieuChiModuleThoiGianRequest extends FormRequest
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
            'thoigianbatdau' => 'required',
            'thoigianketthuc' => 'required'
        ];

        $thoigianbatdau = DateTime::createFromFormat('d/m/Y',trim($this::input('thoigianbatdau')));
        $thoigianketthuc = DateTime::createFromFormat('d/m/Y',trim($this::input('thoigianketthuc')));
        
        if($this::input('thoigianbatdau') && $this::input('thoigianketthuc') && ($thoigianketthuc <  $thoigianbatdau))
        {
            $rules['thoigianketthuc'] = 'after_or_equal:0-0-0';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'thoigianbatdau.required' => 'Vui lòng nhập thời gian bắt đầu',
            'thoigianketthuc.required' => 'Vui lòng nhập thời gian kết thúc',
            'thoigianketthuc.after_or_equal' => 'Thời gian kết thúc không được trước thời thời gian bắt đầu'
        ];
    }
}
