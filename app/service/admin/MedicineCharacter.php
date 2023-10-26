<?php
/**
 * Created by : VsCode
 * User: Dumb Lake Monster (Wang Haiyang)
 * Date:  2023/9/3
 * Time:  14:13
 */

namespace app\service\admin;

use app\service\Common;

class MedicineCharacter
{
    protected $Model = 'MedicineCharacter';

    public function getCollectionBasedOnConditions($conditions)
    {
        $common =  new Common($this->Model);
        $result  = $common->getCollectionBasedOnConditions($conditions);
        return $result;
    }
}