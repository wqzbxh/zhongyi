<?php
/**
 * Created by : VsCode
 * User: Dumb Lake Monster (Wang Haiyang)
 * Date:  2023/9/3
 * Time:  12:08
 */

namespace app\service\admin;

use app\service\Common;
use support\Db;

class MedicinalSmell
{

    protected $Model = 'MedicinalSmell';

    public function getCollectionBasedOnConditions($conditions)
    {
      $common =  new Common($this->Model);
      $result  = $common->getCollectionBasedOnConditions($conditions);
      return $result;
    }
}