<?php
/**
 * Created by : VsCode
 * User: Dumb Lake Monster (Wang Haiyang)
 * Date:  2023/10/8
 * Time:  17:16
 */

namespace app\controller\api;

use app\Message;
use app\service\admin\Prescription;
use support\Request;

class PrescriptionController extends  Prescription
{

    /**
     * 显示草药列表视图。
     *
     * @return \Illuminate\View\View
     */
    public function list()
    {
        return view('admin/prescription/list');
    }

    /**
     * 获取草药列表数据。
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPrescriptionList(Request $request)
    {
        // 从请求中获取页码和限制数量，默认值为 PAGE 和 PAGE_LENGTH
        $page = $request->get('page', 1);
        $limit = $request->get('limit', 10);
        $search= $request->get('search', false);

        // 从请求中获取草药书籍名称，如果未提供则为 null
        $query = $request->get('query', false);
        // 调用 getList 方法获取草药列表数据
        $result = $this->getList($page, $limit, $search,$query);

        // 构造响应消息数组
        $returnArray = Message::Msg(0, null, null, $result);

        // 返回 JSON 格式的响应数据
        return json($returnArray);
    }

    public function searchPrescription(Request $request)
    {
        $search_data = $request->get('search_common_name', false);

        $result = $this->getPrescriptionByCommionName($search_data);
        // 构造响应消息数组
        $returnArray = Message::Msg(0, $result, null, []);

        return json($returnArray);
        // 返回 JSON 格式的响应数据
    }
}