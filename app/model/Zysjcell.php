<?php
/**
 * Created by : VsCode
 * User: Dumb Lake Monster (Wang Haiyang)
 * Date:  2023/8/23
 * Time:  14:31
 */

namespace app\model;

class Zysjcell
{
    public $main_table = 'zysjcell';
    public $association_table = ['zysjllsj'];
    public $main_key = 'Cell_ID';
    public $association_key = ['TypeID'];
    public $showFiled = " SQL_CALC_FOUND_ROWS Cell_ID, Cell_PinYin, Cell_BiaoTi, Cell_JianJie, Cell_NeiRong, Cell_ZhiXingWenJian, Cell_WenJianJia, Cell_ShiJian";
    public $searchFiled = ['Cell_PinYin', 'Cell_BiaoTi'];
}