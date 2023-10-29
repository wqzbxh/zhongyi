<?php
/**
 * Created by : VsCode
 * User: Dumb Lake Monster (Wang Haiyang)
 * Date:  2023/8/23
 * Time:  10:03
 */

namespace app\controller\admin;

use app\service\admin\Books;
use support\Db;
use support\Request;

class HomeController
{
    public function db()
    {
        $name = Db::table('time_project')->select('id','name','project_no','start_date','time_estimate','info','customer_name')->get();

        return json($name);
    }

    public function index()
    {
        return view('admin/home/index');
    }

    public function table()
    {
        return view('admin/home/table');
    }

    public function home()
    {
        return view('admin/home/home');
    }

    public function getBooklist(Request $request)
    {
       $page = $request->get('page', 1);
       $s = $request->get('A');
        $limit = $request->get('limit', 10);
       $BookServer = new Books();
       $result = $BookServer->getList($page,$limit,$s);
        $result['code'] = 0;
        $result['msg'] = 0;
        return json($result);
    }
}