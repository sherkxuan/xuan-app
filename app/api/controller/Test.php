<?php
declare (strict_types = 1);

namespace app\api\controller;

use app\api\common\model\BaseModel;
use app\BaseController;
use think\response\Json;

class Test extends BaseController
{
    use BaseModel;
    /**
     * @return Json
     */
    public function index(): Json
    {
        //
        return $this->error(201,'登录过期','',302);
    }
}
