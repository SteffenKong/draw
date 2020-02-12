<?php

namespace App\Http\Requests\Admin;

/**
 * Class UserAddRequest
 * @package App\Http\Requests\Admin
 * 添加组员校验器
 */
class UserAddRequest extends BaseRequest {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     * 校验规则
     */
    public function rules()
    {
        return [
            'name' => 'required|unique:user',
            'number' => 'required|unique:user',
            'status' => 'required|in:0,1|numeric',
        ];
    }


    /**
     * @return array
     * 错误信息配置
     */
    public function messages() {
        return [
            'name.required' => '请填写组员名',
            'name.unique' => '组员名已存在',
            'number.required' => '请填写组员的员工编号',
            'number.unique' => '员工编号已存在',
            'status.required' => '请选择是否可进行抽签状态',
            'status.in' => '状态取值异常',
            'status.numeric' => '状态取值类型异常'
        ];
    }
}
