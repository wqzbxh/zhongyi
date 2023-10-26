<?php
/**
 * Created by : VsCode
 * User: Dumb Lake Monster (Wang Haiyang)
 * Date:  2023/10/9
 * Time:  14:57
 */

namespace app\Resource;

use think\template\taglib\Cx;

class HerbsReturn
{
    private $data;
    private $type;

    public function __construct($types,$datas) {
        $this->data = $datas;
        $this->type = $types;
    }


    public function __toString() {
        // 创建一个新的一维数组
        $custom_data = array();

        // 循环遍历二维数组中的每个元素
        foreach ($this->data as $index => $item) {
            // 创建一个新的键值对，将二维数组的元素转换为一维数组
            $new_item = array(
                'label' => $item['common_name'],
                'value' => $item['herb_id']
            );
            // 将新的键值对添加到新的一维数组中
            $custom_data["Custom Data {$index}"] = $new_item;
        }

        // 将数组转换为字符串
        return json_encode($custom_data);
    }

}