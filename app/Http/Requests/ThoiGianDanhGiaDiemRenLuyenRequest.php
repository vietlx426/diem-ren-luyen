<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use DateTime;

class ThoiGianDanhGiaDiemRenLuyenRequest extends FormRequest
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
            'hockynamhoc' => 'required',
            'lop' => 'required',
            'thoigianbatdau' => 'required',
            'thoigiankethuc' => 'required'
        ];

        if($this::input('thoigianbatdau') && $this::input('thoigiankethuc'))
        {
            if(DateTime::createFromFormat('d/m/Y',trim($this::input('thoigianbatdau'))) > DateTime::createFromFormat('d/m/Y',trim($this::input('thoigiankethuc'))))
            {
                $rules['thoigiankethuc'] = 'after_or_equal:0-0-0';
            }
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'hockynamhoc.required' => 'Vui lòng chọn học kỳ năm học',
            'lop.required' => 'Vui lòng chọn lớp',
            'thoigianbatdau.required' => 'Vui lòng nhập thời gian bắt đầu',
            'thoigianbatdau.date' => 'Không đúng định dạng',
            'thoigiankethuc.required' => 'Vui lòng nhập thời gian kết thúc',
            'thoigiankethuc.date' => 'Không đúng định dạng',
            'thoigiankethuc.after_or_equal' => 'Thời gian kết thúc không được trước thời gian bắt đầu'
        ];
    }
}
