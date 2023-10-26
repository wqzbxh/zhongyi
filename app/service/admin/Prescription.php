<?php
/**
 * Created by : VsCode
 * User: Dumb Lake Monster (Wang Haiyang)
 * Date:  2023/10/8
 * Time:  17:22
 */

namespace app\service\admin;

use app\service\Common;

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
}