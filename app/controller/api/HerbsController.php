<?php
/**
 * Created by : VsCode
 * User: Dumb Lake Monster (Wang Haiyang)
 * Date:  2023/9/3
 * Time:  2:03
 */

namespace app\controller\admin;

use app\Message;
use app\service\admin\Herbs;
use support\Request;
use support\View;

class HerbsController extends Herbs
{
    /**
     * 显示草药列表视图。
     *
     * @return \Illuminate\View\View
     */
    public function list()
    {
        return view('admin/herbs/list');
    }

    /**
     * 获取草药列表数据。
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getHerbsList(Request $request)
    {
        // 从请求中获取页码和限制数量，默认值为 PAGE 和 PAGE_LENGTH
        $page = $request->get('page', '');
        $limit = $request->get('limit', '');
        $search= $request->get('search', '');

        // 从请求中获取草药书籍名称，如果未提供则为 null
        $query = $request->get('query', '');
        // 调用 getList 方法获取草药列表数据
        $result = $this->getList($page, $limit, $search,$query);

        // 构造响应消息数组
        $returnArray = Message::Msg(0, null, null, $result);

        // 返回 JSON 格式的响应数据
        return json($returnArray);
    }

    public function detail(Request $request)
    {
        $id = $request->get('id', false);

        if($id){
            $row = $this->getHerbsDetail($id);
            var_dump($row);
            View::assign('herbs_info', $row);
        }
//
        return view('admin/herbs/detail');
    }


    public function getSelectList()
    {
        $result =  $this->getSelectListAll();
        // 构造响应消息数组
        $returnArray = Message::Msg(0, $result, null, []);
        // 返回 JSON 格式的响应数据
        return json($returnArray);
    }
}