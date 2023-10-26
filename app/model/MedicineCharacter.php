<?php
/**
 * Created by : VsCode
 * User: Dumb Lake Monster (Wang Haiyang)
 * Date:  2023/9/3
 * Time:  14:11
 */

namespace app\model;

class MedicineCharacter
{
    public $main_table = 'medicine_character';
    public $association_table = ['herbs'];
    public $main_key = 'character_id';
    public $association_key = ['herb_id'];
    public $showFiled = " SQL_CALC_FOUND_ROWS character_id,character_id, character_name";
    public $searchFiled = ['character_name'];
}