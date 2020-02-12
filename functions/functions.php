<?php
if(!function_exists('jsonPrint')) {
    /**
     * @param $code
     * @param $message
     * @param $total
     * @param array $data
     * @param array $extra
     * @return false|string
     * 格式化输出json数据
     */
    function jsonPrint($code,$message,$total,$data = [],$extra = []) {
        return json_encode([
            'code' => $code,
            'message' =>$message,
            'data' => $data,
            'total' => $total,
            'extra' => $extra
        ],JSON_UNESCAPED_UNICODE);
    }
}



if(!function_exists('jsonPrintMessage')) {
    /**
     * @param $code
     * @param $message
     * @param array $extra
     * @return false|string
     * 格式化输出json提示信息
     */
    function jsonPrintMessage($code,$message,$extra = []) {
        return json_encode([
            'code' => $code,
            'message' =>$message,
            'extra' => $extra
        ],JSON_UNESCAPED_UNICODE);
    }
}
