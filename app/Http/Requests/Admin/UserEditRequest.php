<?php

namespace App\Http\Requests\Admin;

/**
 * Class UserEditRequest
 * @package App\Http\Requests\Admin
 * 编辑组员校验器
 */
class UserEditRequest extends BaseRequest {

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
            'name' => 'required',
            'number' => 'required',
            'status' => 'required|in:0,1|numeric',
        ];
    }


    /**
     * @return array
     * 错误信息配置
     */
    public function messages() {
        return [
            'id.required' => 'id不能为空',
            'id.numeric' => 'id值类型异常',
            'id.notIn' => 'id值不能为0',
            'name.required' => '请填写组员名',
            'number.required' => '请填写组员的员工编号',
            'status.required' => '请选择是否可进行抽签状态',
            'status.in' => '状态取值异常',
            'status.numeric' => '状态取值类型异常'
        ];
    }
}
