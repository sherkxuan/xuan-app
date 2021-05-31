<?php
declare (strict_types = 1);

namespace app\api\controller;

use app\api\common\model\BaseModel;
use app\api\validate\TopicValidate;
use app\BaseController;
use Exception;
use think\Request;
use think\response\Json;

/**
 * 话题管理器
 * Class Topic
 * @package app\api\controller
 */
class Topic extends BaseController
{
    use BaseModel;

    public function index()
    {
        //
    }

    /**
     * @throws Exception
     */
    public function save(): Json
    {
        $data = (new TopicValidate())->getCheck('create','207');
        $data['user_id'] = getUid();
        $this->topicModel->save($data);
        return $this->success($data);
    }


    public function read($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }

    public function delete($id)
    {
        //
    }
}
