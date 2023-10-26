<?php
/**
 * Created by : VsCode
 * User: Dumb Lake Monster (Wang Haiyang)
 * Date:  2023/9/3
 * Time:  14:26
 */

namespace app\model;

class Toxicity
{
    public $main_table = 'toxicity';
    public $association_table = ['herbs'];
    public $main_key = 'toxicity_id';
    public $association_key = ['herb_id'];
    public $showFiled = " SQL_CALC_FOUND_ROWS toxicity_id, toxicity_name, toxicity_id";
    public $searchFiled = ['toxicity_name'];
}