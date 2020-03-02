<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SinhVienProfileRequest extends FormRequest
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
        if($this::input('id'))
        {
            $rules = [
                'picprofile' => 'image',
                'dienthoai' => 'required|numeric|digits_between:10, 11',
                'email' => 'required|email',
                'noisinh' => 'required',
                // 'cmnd' => 'required|numeric|digits:9',
                'ngaycapcmnd' => 'required|date|after:01/01/1950|before:now',
                'noicapcmnd' => 'required',
                'tinh' => 'required|notin:0',
                'huyen' => 'required|notin:0',
                'xa' => 'required|notin:0',
                'hokhauthuongtru' => 'required',
                'tinh_tamtru' => 'required|notin:0',
                'huyen_tamtru' => 'required|notin:0',
                'xa_tamtru' => 'required|notin:0',
                'diachitamtru' => 'required',
                'dantoc' => 'required|notin:0',
                'tongiao' => 'required|notin:0',
                'ngayvaodoan' => 'required_with:noivaodoan',
                'noivaodoan' => 'required_with:ngayvaodoan',
                'ngayvaodang' => 'required_with:noivaodang',
                'noivaodang' => 'required_with:ngayvaodang',

                // 'hotencha' => 'required_with:ngaysinhcha|required_with:dienthoaicha|required_with:nghenghiepcha|required_with:noilamvieccha|required_with:hokhauthuongtrucha',

                // 'hotenme' => 'required_with:ngaysinhme|required_with:dienthoaime|required_with:nghenghiepme|required_with:noilamviecme|required_with:hokhauthuongtrume',


            ];

            // Validation ngày vào đoàn nếu có dữ liệu nơi vào đoàn
            if($this::input('noivaodoan'))
            {
                $rules['ngayvaodoan'] = 'required|after:01/01/1950|before:now';
            }

            // Validation ngày vào đảng nếu có dữ liệu nơi vào đảng
            if($this::input('noivaodang'))
            {
                $rules['ngayvaodang'] = 'required|after:1950-01-01|before:now';
            }

            // Validation Dad's information if has Dad's name
            if(!$this::input('dienmocoi_cha'))
            {
                // if($this::input('hotencha'))
                // {
                    $rules['hotencha'] = 'required';
                    $rules['ngaysinhcha'] = 'required|after:01/01/1900|before:now';
                    $rules['dienthoaicha'] = 'required|numeric|digits_between:10,11';
                    $rules['dantoccha'] = 'required|notin:0';
                    $rules['nghenghiepcha'] = 'required';
                    $rules['noilamvieccha'] = 'required';
                    $rules['tinh_thuongtru_cha'] = 'required|notin:0';
                    $rules['huyen_thuongtru_cha'] = 'required|notin:0';
                    $rules['xa_thuongtru_cha'] = 'required|notin:0';
                    $rules['hokhauthuongtrucha'] = 'required';
                // }
            }

            // Validation Dad's information if has Dad's name
            if(!($this::input('dienmocoi_me')))
            {
                // if($this::input('hotenme'))
                // {
                    $rules['hotenme'] = 'required';
                    $rules['ngaysinhme'] = 'required|after:01/01/1900|before:now';
                    $rules['dienthoaime'] = 'required|numeric|digits_between:10,11';
                    $rules['dantocme'] = 'required|notin:0';
                    $rules['nghenghiepme'] = 'required';
                    $rules['noilamviecme'] = 'required';
                    $rules['tinh_thuongtru_me'] = 'required|notin:0';
                    $rules['huyen_thuongtru_me'] = 'required|notin:0';
                    $rules['xa_thuongtru_me'] = 'required|notin:0';
                    $rules['hokhauthuongtrume'] = 'required';
                // }
            }
        }
        else
        {
            $rules = [
                'picprofile' => 'required|image',
                'dienthoai' => 'required|numeric|digits_between:10, 11',
                'email' => 'required|email',
                'noisinh' => 'required',
                // 'cmnd' => 'required|numeric|digits:9',
                'ngaycapcmnd' => 'required|date|after:01/01/1950|before:now',
                'noicapcmnd' => 'required',
                'tinh' => 'required|notin:0',
                'huyen' => 'required|notin:0',
                'xa' => 'required|notin:0',
                'hokhauthuongtru' => 'required',
                'tinh_tamtru' => 'required|notin:0',
                'huyen_tamtru' => 'required|notin:0',
                'xa_tamtru' => 'required|notin:0',
                'diachitamtru' => 'required',
                'dantoc' => 'required|notin:0',
                'tongiao' => 'required|notin:0',
                'ngayvaodoan' => 'required_with:noivaodoan',
                'noivaodoan' => 'required_with:ngayvaodoan',
                'ngayvaodang' => 'required_with:noivaodang',
                'noivaodang' => 'required_with:ngayvaodang',

                // 'hotencha' => 'required_with:ngaysinhcha|required_with:dienthoaicha|required_with:nghenghiepcha|required_with:noilamvieccha|required_with:hokhauthuongtrucha',

                // 'hotenme' => 'required_with:ngaysinhme|required_with:dienthoaime|required_with:nghenghiepme|required_with:noilamviecme|required_with:hokhauthuongtrume',


            ];

            // Validation ngày vào đoàn nếu có dữ liệu nơi vào đoàn
            if($this::input('noivaodoan'))
            {
                $rules['ngayvaodoan'] = 'required|after:01/01/1950|before:now';
            }

            // Validation ngày vào đảng nếu có dữ liệu nơi vào đảng
            if($this::input('noivaodang'))
            {
                $rules['ngayvaodang'] = 'required|after:1950-01-01|before:now';
            }

            // Validation Dad's information if has Dad's name
            if(!$this::input('dienmocoi_cha'))
            {
                // if($this::input('hotencha'))
                // {
                    $rules['hotencha'] = 'required';
                    $rules['ngaysinhcha'] = 'required|after:01/01/1900|before:now';
                    $rules['dienthoaicha'] = 'required|numeric|digits_between:10,11';
                    $rules['dantoccha'] = 'required|notin:0';
                    $rules['nghenghiepcha'] = 'required';
                    $rules['noilamvieccha'] = 'required';
                    $rules['tinh_thuongtru_cha'] = 'required|notin:0';
                    $rules['huyen_thuongtru_cha'] = 'required|notin:0';
                    $rules['xa_thuongtru_cha'] = 'required|notin:0';
                    $rules['hokhauthuongtrucha'] = 'required';
                // }
            }

            // Validation Dad's information if has Dad's name
            if(!($this::input('dienmocoi_me')))
            {
                // if($this::input('hotenme'))
                // {
                    $rules['hotenme'] = 'required';
                    $rules['ngaysinhme'] = 'required|after:01/01/1900|before:now';
                    $rules['dienthoaime'] = 'required|numeric|digits_between:10,11';
                    $rules['dantocme'] = 'required|notin:0';
                    $rules['nghenghiepme'] = 'required';
                    $rules['noilamviecme'] = 'required';
                    $rules['tinh_thuongtru_me'] = 'required|notin:0';
                    $rules['huyen_thuongtru_me'] = 'required|notin:0';
                    $rules['xa_thuongtru_me'] = 'required|notin:0';
                    $rules['hokhauthuongtrume'] = 'required';
                // }
            }
        }

        return $rules;
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            //Cá nhân
            'picprofile.required' => "Chọn file ảnh",
            'picprofile.image' => "Chọn đúng file ảnh (jpeg, png, bmp, gif, or svg)",

            'dienthoai.required' => 'Vui lòng nhập số điện thoại',
            'dienthoai.numeric' => 'Vui lòng nhập điện thoại chỉ chứa số',
            'dienthoai.digits_between' => 'Số điện thoại phải từ 10 đến 11 số',

            'email.required' => 'Vui lòng nhập địa chỉ email',
            'email.email' => 'Địa chỉ không đúng dạng email',
            
            'noisinh.required' => 'Vui lòng nhập nơi sinh',

            'cmnd.required' => 'Vui lòng nhập số chứng minh nhân dân',
            'cmnd.numeric' => 'Chứng minh nhân dân chỉ chứa số',
            'cmnd.digits' => 'Nhập số chứng minh nhân dân đúng 9 chữ số',

            'ngaycapcmnd.required' => 'Vui lòng nhập ngày cấp chứng minh nhân dân',
            'ngaycapcmnd.before' => 'Ngày cấp chứng minh nhân dân không hợp lệ',
            'ngaycapcmnd.after' => 'Ngày cấp chứng minh nhân dân không hợp lệ',

            'noicapcmnd.required' => 'Vui lòng nhập nơi cấp chứng minh nhân dân',

            'tinh.required' => 'Vui lòng chọn tỉnh',
            'tinh.notin' => 'Vui lòng chọn tỉnh',
            'huyen.required' => 'Vui lòng chọn huyện',
            'huyen.notin' => 'Vui lòng chọn huyện',
            'xa.required' => 'Vui lòng chọn xã',
            'xa.notin' => 'Vui lòng chọn xã',
            'hokhauthuongtru.required' => 'Vui lòng nhập địa chỉ thường trú theo hộ khẩu',

            'tinh_tamtru.required' => 'Vui lòng chọn tỉnh',
            'tinh_tamtru.notin' => 'Vui lòng chọn tỉnh',
            'huyen_tamtru.required' => 'Vui lòng chọn huyện',
            'huyen_tamtru.notin' => 'Vui lòng chọn huyện',
            'xa_tamtru.required' => 'Vui lòng chọn xã',
            'xa_tamtru.notin' => 'Vui lòng chọn xã',
            'diachitamtru.required' => 'Vui lòng nhập địa chỉ tạm trú',

            'dantoc.required' => 'Vui lòng chọn dân tộc',
            'dantoc.notin' => 'Vui lòng chọn dân tộc',

            'tongiao.required' => 'Vui lòng chọn tôn giáo',
            'tongiao.notin' => 'Vui lòng chọn tôn giáo',

            'ngayvaodoan.required_with' => 'Vui lòng nhập ngày vào Đoàn TNCS HCM',
            'ngayvaodoan.required' => 'Vui lòng nhập ngày vào Đoàn TNCS HCM',
            'ngayvaodoan.before' => 'Ngày vào Đoàn không hợp lệ',
            'ngayvaodoan.after' => 'Ngày vào Đoàn không hợp lệ',

            'noivaodoan.required_with' => 'Vui lòng nhập nơi vào Đoàn TNCS HCM',

            'ngayvaodang.required_with' => 'Vui lòng nhập ngày vào Đảng CSVN',
            'ngayvaodang.required' => 'Vui lòng nhập ngày vào Đảng CSVN',
            'ngayvaodang.before' => 'Ngày vào Đảng không hợp lệ',
            'ngayvaodang.after' => 'Ngày vào Đảng không hợp lệ',


            'noivaodang.required_with' => 'Vui lòng nhập nơi vào Đảng CSVN',

            // validation cha
            'hotencha.required_with' => 'Vui lòng nhập họ tên cha',
            'hotencha.required' => 'Vui lòng nhập họ tên cha',

            'ngaysinhcha.required' => 'Vui lòng nhập ngày sinh',
            'ngaysinhcha.before' => 'Ngày sinh không hợp lệ',
            'ngaysinhcha.after' => 'Ngày sinh không hợp lệ',

            'dienthoaicha.required' => 'Vui lòng nhập số điện thoại',
            'dienthoaicha.numeric' => 'Vui lòng nhập điện thoại chỉ chứa số',
            'dienthoaicha.digits_between' => 'Số điện thoại phải từ 10 đến 11 số',

            'dantoccha.required' => 'Vui lòng chọn dân tộc',
            'dantoccha.notin' => 'Vui lòng chọn dân tộc',

            'nghenghiepcha.required' => 'Vui lòng nhập nghề nghiệp',

            'noilamvieccha.required' => 'Vui lòng nhập nơi làm việc',

            'tinh_thuongtru_cha.required' => 'Vui lòng chọn tỉnh',
            'tinh_thuongtru_cha.notin' => 'Vui lòng chọn tỉnh',
            'huyen_thuongtru_cha.required' => 'Vui lòng chọn huyện',
            'huyen_thuongtru_cha.notin' => 'Vui lòng chọn huyện',
            'xa_thuongtru_cha.required' => 'Vui lòng chọn xã',
            'xa_thuongtru_cha.notin' => 'Vui lòng chọn xã',
            'hokhauthuongtrucha.required' => 'Vui lòng nhập địa chỉ hộ khẩu thường trú',

            // validation mẹ
            'hotenme.required_with' => 'Vui lòng nhập họ tên mẹ',
            'hotenme.required' => 'Vui lòng nhập họ tên mẹ',

            'ngaysinhme.required' => 'Vui lòng nhập ngày sinh',
            'ngaysinhme.before' => 'Ngày sinh không hợp lệ',
            'ngaysinhme.after' => 'Ngày sinh không hợp lệ',

            'dienthoaime.required' => 'Vui lòng nhập số điện thoại',
            'dienthoaime.numeric' => 'Vui lòng nhập điện thoại chỉ chứa số',
            'dienthoaime.digits_between' => 'Số điện thoại phải từ 10 đến 11 số',

            'dantocme.required' => 'Vui lòng chọn dân tộc',
            'dantocme.notin' => 'Vui lòng chọn dân tộc',

            'nghenghiepme.required' => 'Vui lòng nhập nghề nghiệp',

            'noilamviecme.required' => 'Vui lòng nhập nơi làm việc',

            'tinh_thuongtru_me.required' => 'Vui lòng chọn tỉnh',
            'tinh_thuongtru_me.notin' => 'Vui lòng chọn tỉnh',
            'huyen_thuongtru_me.required' => 'Vui lòng chọn huyện',
            'huyen_thuongtru_me.notin' => 'Vui lòng chọn huyện',
            'xa_thuongtru_me.required' => 'Vui lòng chọn xã',
            'xa_thuongtru_me.notin' => 'Vui lòng chọn xã',
            'hokhauthuongtrume.required' => 'Vui lòng nhập địa chỉ hộ khẩu thường trú',
        ];
    }
}
