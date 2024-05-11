<?php

namespace app\controller;

use app\Message;
use app\service\admin\Books;
use support\Db;
use support\Request;

class IndexController extends Books
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

    public function getBooklist(Request $request)
    {
        $page = $request->get('page', '');
        $limit = $request->get('limit', '');
        $s = $request->get('A');
        $BookServer = new Books();
        // 调用 getList 方法获取草药列表数据
        $result = $this->getList($page, $limit, $s);
        // 构造响应消息数组
        $returnArray = Message::Msg(0, null, null, $result);

        // 返回 JSON 格式的响应数据
        return json($returnArray);
    }

}
