<?php
/**
 * Created by : VsCode
 * User: Dumb Lake Monster (Wang Haiyang)
 * Date:  2023/9/3
 * Time:  1:03
 */

namespace app\model;

class Books
{
    public $main_table = 'books';
    public $association_table = ['herbs'];
    public $main_key = 'book_id';
    public $association_key = ['book_id'];
    public $showFiled = " SQL_CALC_FOUND_ROWS book_id, book_name, book_author, Introduction, create_at";
    public $searchFiled = ['book_name', 'book_author','Introduction'];
}