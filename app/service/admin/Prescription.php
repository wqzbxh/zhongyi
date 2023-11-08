<?php
/**
 * Created by : VsCode
 * User: Dumb Lake Monster (Wang Haiyang)
 * Date:  2023/10/8
 * Time:  17:22
 */

namespace app\service\admin;

use app\service\Common;
use support\Db;

class Prescription
{
    protected $Model = 'Prescription';

    public $database_info_object;

    public function getList($page,$limit,$search,$query)
    {
        $Common = new Common($this->Model);
        $result =  $Common->getList($page,$limit,$search,$query);

        return $result;
    }

    public function getPrescription($params)
    {
//        if(!empty($params[])){
//            getPrescriptionByCommionName($params);
//        }
    }


    public function getPrescriptionByCommionName($params)
    {
        if(is_array($params)){
//            计算药物数量，共查询使用
            $count = count($params);

            $params = array_map(function($value) {
                return "'" . $value . "'";
            }, $params);

            $implodedParams = implode(',', $params);

            $params = implode(',',$params);
            $HerbsModel = new \app\model\Herbs();
//            查询药物名字（包括重复的ID一起查询，目的不同的书籍存在相同的名字，只要是要查询的名字出现，不论哪本书籍都要进入查询）
             $sql_search = "select * from prescription where prescription_id in (
                        SELECT prescription_id
                        FROM prescription_sku
                        WHERE  herbs_id IN (SELECT herb_id FROM herbs where  common_name in  ({$params})) 
                        GROUP BY prescription_id
                        HAVING COUNT(DISTINCT herbs_id) = {$count});
                        ";
            $retrult = Db::select($sql_search);
            return $retrult;
        }else{

        }
    }


    public function getDetailFuncrion(int $prescription_id)
    {
        $retrult = [
            'conditions_retrult' => [],
            'prescription_sku' => []
        ];
//        主治病症
        $sql_conditions_search = "select symptoms,condition_id from conditions where prescription_id = {$prescription_id};";
        $conditions_retrult = Db::select($sql_conditions_search);
//      药物组合

        $sql_prescription_sku = "select h.common_name,d.dosage_number,u.unit_symbol from prescription_sku ps left JOIN units u on u.unit_id = ps.units_id  
                                left JOIN dosages d on d.dosage_id  = ps.dosages_id  
                                left JOIN herbs h    on h.herb_id  = ps.herbs_id   where ps.prescription_id = 2";
        $prescription_sku_retrult = Db::select($sql_prescription_sku);

        $retrult = [
            'conditions_retrult' =>$conditions_retrult,
            'prescription_sku' => $prescription_sku_retrult
        ];

        return $retrult;
    }
}