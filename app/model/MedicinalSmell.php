<?php
/**
 * Created by : VsCode
 * User: Dumb Lake Monster (Wang Haiyang)
 * Date:  2023/9/3
 * Time:  12:01
 */

namespace app\model;

class MedicinalSmell
{
    public $main_table = 'medicinal_smell';
    public $association_table = ['herbs'];
    public $main_key = 'medicinal_smell_id';
    public $association_key = ['herb_id'];
    public $showFiled = " SQL_CALC_FOUND_ROWS medicinal_smell_id,medicinal_smell_id, medicinal_smell_name";
    public $searchFiled = ['medicinal_smell_name'];
}