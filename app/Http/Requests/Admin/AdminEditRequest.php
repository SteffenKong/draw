<?php

namespace App\Http\Requests\Admin;

/**
 * Class AdminEditRequest
 * @package App\Http\Requests\Admin
 * 编辑管理员校验器
 */
class AdminEditRequest extends BaseRequest {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     * 校验规则
     */
    public function rules()
    {
        return [
            'id' => 'required|numeric|notIn:0',
            'account' => 'required',
            'status' => 'required|in:0,1|numeric',
            'loginSetting' => 'required|in:0,1|numeric',
            'email' => 'required|email',
            'phone' => 'required'
        ];
    }


    /**
     * @return array
     * 错误信息配置
     */
    public function messages() {
        return [
            'id.required' => 'id不能为空',
            'id.numeric' => 'id编号数值类型错误',
            'id.notIn' => 'id编号取值异常',
            'account.required' => '请填写账号名',
            'status.required' => '请选择是否可进行抽签状态',
            'status.in' => '状态取值异常',
            'status.numeric' => '状态取值类型异常',
            'loginSetting.required' => '请选择是否可进行抽签状态',
            'loginSetting.in' => '状态取值异常',
            'loginSetting.numeric' => '状态取值类型异常',
            'email.required' => '请填写邮箱',
            'email.email' => '邮箱格式错误',
            'phone.required' => '请填写手机号码',
        ];
    }
}
