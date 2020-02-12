<?php

namespace App\Http\Requests\Admin;

/**
 * Class AdminAddRequest
 * @package App\Http\Requests\Admin
 * 添加管理员校验器
 */
class AdminAddRequest extends BaseRequest {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     * 校验规则
     */
    public function rules()
    {
        return [
            'account' => 'required|unique:admin',
            'status' => 'required|in:0,1|numeric',
            'loginSetting' => 'required|in:0,1|numeric',
            'email' => 'required|email|unique:admin_info',
            'phone' => 'required|unique:admin_info'
        ];
    }


    /**
     * @return array
     * 错误信息配置
     */
    public function messages() {
        return [
            'account.required' => '请填写账号名',
            'account.unique' => '账号已存在',
            'status.required' => '请选择是否可进行抽签状态',
            'status.in' => '状态取值异常',
            'status.numeric' => '状态取值类型异常',
            'loginSetting.required' => '请选择是否可进行抽签状态',
            'loginSetting.in' => '状态取值异常',
            'loginSetting.numeric' => '状态取值类型异常',
            'email.required' => '请填写邮箱',
            'email.email' => '邮箱格式错误',
            'email.unique' => '邮箱已存在',
            'phone.required' => '请填写手机号码',
            'phone.unique' => '手机号码已存在',
        ];
    }
}
