<?php
/**
 * Created by : VsCode
 * User: Dumb Lake Monster (Wang Haiyang)
 * Date:  2023/9/3
 * Time:  1:03
 */

namespace app\model;

class Herbs
{
    public $main_table = 'herbs';
    public $association_table = ['medicinal_smell','medicine_character','toxicity','books'];
    public $main_key = 'herb_id';
    public $association_key = ['medicinal_smell_id','character_id','toxicity_id','book_id'];
    public $showFiled = " SQL_CALC_FOUND_ROWS common_name,herb_id as id,other_names,scientific_name,medicinal_smell_id, character_id,  toxicity_id,  book_id,  efficacy, origin, type, created_at";
    public $searchFiled = ['common_name', 'efficacy','other_names','scientific_name'];
    public $selectFiled = [ 'herb_id as value','common_name as lable'];


    /**
     * 与模型关联的表名
     *
     * @var string
     */
    protected $table = 'herbs';
    /**
     * 重定义主键，默认是id
     *
     * @var string
     */
    protected $primaryKey = 'herb_id';

    /**
     * 指示是否自动维护时间戳
     *
     * @var bool
     */
    public $timestamps = false;
}