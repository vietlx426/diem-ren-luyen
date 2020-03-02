<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserGroupStatusRequest extends FormRequest
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
            //
            Array ( [_token] => Jg1ChfXSQKYP9qzdPfzkkO9NdS6g3fLfxaaUBtzr [Name] => Nguyễn Thị Kim Điệp [Email] => ntkdiep_43kt@student.agu.edu.vn [GroupPermission] => Array ( [0] => 2 [1] => 8 ) [TrangThaiUser] => 1 )
        ];
    }
}
