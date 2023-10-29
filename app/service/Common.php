<?php
/**
 * Created by : VsCode
 * User: Dumb Lake Monster (Wang Haiyang)
 * Date:  2023/9/3
 * Time:  2:06
 */

namespace app\service;

use app\model\Books;
use support\Db;

class Common
{
    public $database_info_object;

    public function __construct($Model)
    {
        // 构建完整的类名
        $className = 'app\model\\' . $Model;
        // 创建对象并赋值给属性
        $this->database_info_object = new $className();
    }



    /**
     * 获取列表数据，包括分页和搜索功能。
     *
     * @param int $page 当前页码
     * @param int $limit 每页显示数量
     * @param string $search 搜索关键词
     * @return array 包含数据和总数的关联数组
     */
    public function getList($page = null, $limit= null, $search= null,$queryWhere=[])
    {
        $result = [];
        $total = 0;
        // 构建原生表达式查询
        $query = Db::table($this->database_info_object->main_table)
            ->selectRaw($this->database_info_object->showFiled);

        if (is_array($queryWhere) && count($queryWhere) > 0) {
            $query->where(function ($query) use ($queryWhere) {
                foreach ($queryWhere as $key => $item) {
                    if (!empty($item)) {
                        $query->orWhere($key, '=', $item);
                    }
                }
            });
        }

// 如果有搜索关键词，添加搜索条件
        if (!empty($search)) {
            $query->where(function ($query) use ($search) {
                foreach ($this->database_info_object->searchFiled as $item) {
                    $query->orWhere($item, 'like', "%$search%");
                }
            });
        }

        if(!empty($page)){
            // 执行查询
            $result = $query->offset(($page - 1) * $limit)
                ->limit($limit)
                ->get();
        }else{
            $result = $query->get();
        }


        // 获取总数
        $totalQuery = "SELECT FOUND_ROWS() AS total";
        $totalResult = Db::select($totalQuery);
        $total = $totalResult[0]->total;

        // 构建返回的关联数组
        $returnArray = [
            'data' => $result,
            'total' => $total,
        ];

        return $returnArray;
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
}