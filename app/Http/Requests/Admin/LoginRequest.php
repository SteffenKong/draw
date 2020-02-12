<?php

namespace App\Http\Requests\Admin;

/**
 * Class LoginRequest
 * @package App\Http\Requests\Admin
 * 登录校验器
 */
class LoginRequest extends BaseRequest {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     * 校验规则
     */
    public function rules()
    {
        return [
            'account' => 'required',
            'password' => 'required',
            'captcha' => 'required|captcha'
        ];
    }


    /**
     * @return array
     * 错误信息配置
     */
    public function messages() {
        return [
            'account.required' => '请填写账号',
            'password.required' =>'请填写密码',
            'captcha.required' =>'请填写验证码',
            'captcha.captcha' =>'验证码错误'
        ];
    }
}
