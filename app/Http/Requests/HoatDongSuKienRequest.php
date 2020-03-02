<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use DateTime;

class HoatDongSuKienRequest extends FormRequest
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
            'tenhoatdongsukien' => 'required',
            'loaihoatdongsukien' => 'required',
            'thoigianbatdau' => 'required',
            'thoigianketthuc' => 'required',
            'diadiem' => 'required',
            'hockynamhoc' => 'required',
            'selected_rating' => 'required'
        ];

        $thoigianbatdau = DateTime::createFromFormat('d/m/Y h:i A',trim($this::input('thoigianbatdau')));
        $thoigianketthuc = DateTime::createFromFormat('d/m/Y h:i A',trim($this::input('thoigianketthuc')));
        
        if($this::input('thoigianbatdau') && $this::input('thoigianketthuc') && ($thoigianketthuc <  $thoigianbatdau))
        {
            $rules['thoigianketthuc'] = 'after_or_equal:0-0-0';
        }

        if($this::input('thoigianBDDK') || $this::input('thoigianKTDK'))
        {
            $rules['thoigianBDDK'] = 'required';
            $rules['thoigianKTDK'] = 'required';

            if($this::input('thoigianBDDK') && $this::input('thoigianbatdau'))
            {
                $thoigianBDDK = DateTime::createFromFormat('d/m/Y',trim($this::input('thoigianBDDK')));
                if($thoigianBDDK > $thoigianbatdau)
                    $rules['thoigianBDDK'] = 'after_or_equal:0-0-0';
            }

            if($this::input('thoigianKTDK') && $this::input('thoigianBDDK'))
            {
                $thoigianKTDK = DateTime::createFromFormat('d/m/Y',trim($this::input('thoigianKTDK')));
                if($thoigianKTDK < $thoigianBDDK)
                    $rules['thoigianKTDK'] = 'after_or_equal:0-0-0';
            }
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'tenhoatdongsukien.required' => 'Vui lòng nhập tên hoạt động sự kiện',
            'loaihoatdongsukien.required' => 'Vui lòng chọn loại hoạt động sự kiện',
            'thoigianbatdau.required' => 'Vui lòng nhập thời gian bắt đầu',
            'thoigianketthuc.required' => 'Vui lòng nhập thời gian kết thúc',
            'thoigianketthuc.after_or_equal' => 'Thời gian kết thúc không được trước thời thời gian bắt đầu',
            'thoigianBDDK.required' => 'Vui lòng nhập thời gian bắt đầu đăng ký',
            'thoigianBDDK.after_or_equal' => 'Thời gian bắt đầu đăng ký không được sau thời thời gian bắt đầu',
            'thoigianKTDK.required' => 'Vui lòng nhập thời gian kết thúc đăng ký',
            'thoigianKTDK.after_or_equal' => 'Thời gian kết thúc đăng ký không được trước thời thời gian bắt đầu đăng ký',
            'diadiem.required' => 'Vui lòng nhập địa điểm',
            'selected_rating.required' => 'Vui lòng chọn mức xếp loại hoạt động sự kiện'
        ];
    }
}
