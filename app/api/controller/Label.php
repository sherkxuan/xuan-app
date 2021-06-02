<?php
declare (strict_types = 1);

namespace app\api\controller;

use app\api\common\model\BaseModel;
use app\api\middleware\CheckToken;
use app\api\validate\LabelValidate;
use app\BaseController;
use Exception;

use think\App;
use think\Request;
use think\response\Json;


class Label extends BaseController
{
    use BaseModel;
    protected array $middleware = [CheckToken::class];

    public function index()
    {
        //
    }


    /**
     * @throws Exception
     * @noinspection PhpUndefinedFieldInspection
     */
    public function save(Request $request): Json
    {

        $data = (new LabelValidate())->getCheck('create','209');
        $data['user_id'] = $request->uid;
        $this->labelModel->save($data);
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
