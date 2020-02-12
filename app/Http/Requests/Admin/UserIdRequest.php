<?php

namespace App\Http\Requests\Admin;

/**
 * Class UserIdRequest
 * @package App\Http\Requests\Admin
 * 组员id校验器
 */
class UserIdRequest extends BaseRequest {

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
        ];
    }
}
