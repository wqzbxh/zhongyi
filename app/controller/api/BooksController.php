<?php
/**
 * Created by : VsCode
 * User: Dumb Lake Monster (Wang Haiyang)
 * Date:  2023/9/3
 * Time:  1:08
 */

namespace app\controller\api;

use app\Message;
use app\service\admin\Books;
use support\Request;

class BooksController extends Books
{

    public function list()
    {
        return view('admin/books/list');
    }

    public function getBooklist(Request $request)
    {
        $paginationInfo = $request->get('pagination', '');

        $page = $paginationInfo['current'];
        $limit = $paginationInfo['pageSize'];

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