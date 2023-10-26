<?php
/**
 * Created by : VsCode
 * User: Dumb Lake Monster (Wang Haiyang)
 * Date:  2023/10/8
 * Time:  17:23
 */

namespace app\model;

class Prescription
{
    public $main_table = 'prescription';
    public $association_table = ['medicinal_smell','medicine_character','toxicity','books'];
    public $main_key = 'prescription_id';
    public $association_key = ['medicinal_smell_id','character_id','toxicity_id','book_id'];
    public $showFiled = " SQL_CALC_FOUND_ROWS prescription_id,prescription_name,pl,method_name";
    public $searchFiled = ['prescription_name', 'method_name','pl'];
}