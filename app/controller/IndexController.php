<?php

namespace app\controller;

use support\Db;
use support\Request;

class IndexController
{
    public function index(Request $request)
    {
        static $readme;
        if (!$readme) {
            $readme = file_get_contents(base_path('README.md'));
        }
        return $readme;
    }

    public function view(Request $request)
    {
        return view('index/view', ['name' => '1111']);
    }

    public function json(Request $request)
    {
        return json(['code' => 0, 'msg' => 'ok']);
    }

    public function hello(Request $request)
    {
        $default_name = 'webman';
        // 从get请求里获得name参数，如果没有传递name参数则返回$default_name
        $name = $request->get('name', $default_name);
        // 向浏览器返回字符串
        return response('123213 ' . $name);
    }


    public function db()
    {
        $name = Db::table('time_project')->select('id','name','project_no','start_date','time_estimate','info','customer_name')->get();

        return json($name);
    }

}
