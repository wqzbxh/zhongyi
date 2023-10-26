<?php
/**
 * Created by : VsCode
 * User: Dumb Lake Monster (Wang Haiyang)
 * Date:  2023/8/23
 * Time:  10:32
 */

namespace app\service\admin;

use app\service\Common;
use support\Db;

class Books
{

    protected $Model = 'Books';

    public $database_info_object;

    public function geDataObj()
    {
        // 构建完整的类名
        $className = 'app\model\\' . $this->Model;
        // 创建对象并赋值给属性
        $this->database_info_object = new $className();
    }

    public function getList($page,$limit,$book_name)
    {
        $Common = new Common($this->Model);
        $result =  $Common->getList($page,$limit,$book_name);
        return $result;
    }


    public function getCollectionBasedOnConditions($conditions)
    {
        // 构建原生表达式查询
        $query = Db::table($this->database_info_object->main_table)
            ->selectRaw($this->database_info_object->showFiled);
        foreach ($conditions as $key => $item) {
            if($item['operator'] == 'whereIn'){
                $query->whereIn($item['key'],$item['value']);
            }

            if($item['operator'] == '='){
                $query->where($item['key'],'=',$item['value']);
            }
        }
        // 执行查询
        $result = $query->get()->toArray();

        return $result;
    }

    /**
     * @return void
     *
     */
    public function getBookWhereIn()
    {

    }
}