<?php
declare (strict_types = 1);

namespace app\api\controller;

use app\api\common\model\BaseModel;
use app\api\middleware\CheckToken;
use app\api\validate\LabelValidate;
use app\BaseController;
use Exception;

//use think\App;
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
     * 实验性加数据
     * @throws Exception
     * @noinspection PhpUndefinedFieldInspection
     */
    public function save(Request $request): Json
    {
        $data = (new LabelValidate())->getCheck('create','209');
        $labels = $this->labelModel->field('name')->column('name');
        //如果是数组
        if(is_array($data)){
            $ids = $this->userModel->field('id')->orderRand()->where('is_robot',1)->limit(count($data['name']))->select();
            $data = array_map(function($item,$uu){
                return [
                    'user_id'=>$uu['id'],
                    'name'=>$item
                ];
            },$data['name'],$ids->toArray());

            foreach ($data as $key=>$item){
                if(in_array($item['name'],$labels)){
                    unset($data[$key]);
                }
            }
            if(empty($data)){
                return $this->error('220','当前标签已存在');
            }
            $res = $this->labelModel->saveAll($data);
        }else{
            if(in_array($data['name'],$labels)){
                return $this->error('220','当前标签已存在');
            }
            $res = $this->labelModel->save(['name'=>$data['name'],'user_id'=>$request->uid]);
        }
        return $this->success($res);
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
