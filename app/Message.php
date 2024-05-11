<?php
/**
 * Created by : VsCode
 * User: Dumb Lake Monster (Wang Haiyang)
 * Date:  2023/9/3
 * Time:  1:27
 */

namespace app;

class Message
{
    // 定义消息代码与消息文本的映射
    const CODEMSG = [
        0 => '成功'
    ];

    /**
     * 构造响应消息数组
     *
     * @param int $code 消息代码
     * @param mixed $data 数据
     * @param string|null $msg 自定义消息文本（可选）
     * @param array $extraFields 额外的字段（可选）
     *
     * @return array 响应消息数组，包括消息代码、消息文本、数据和额外字段
     */
    public static function Msg($code = 0, $data = [], $msg = null, $extraFields = [])
    {
        // 初始化响应消息数组
        $msgArray = [
            'code' => $code, // 设置消息代码
            'msg' => self::CODEMSG[$code], // 根据代码获取默认消息文本
            'data' => $data // 设置数据
        ];

        // 如果提供了自定义消息文本，则覆盖默认消息文本
        if ($msg) {
            $msgArray['msg'] = $msg;
        }

        // 添加额外的字段到响应消息数组

        foreach ($extraFields as $key => $value) {
            $msgArray[$key] = $value;
        }

        return $msgArray; // 返回响应消息数组
    }

}

