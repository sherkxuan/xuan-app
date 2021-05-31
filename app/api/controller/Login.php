<?php
declare (strict_types = 1);

namespace app\api\controller;

use app\api\common\model\BaseModel;
use app\api\validate\LoginValidate;
use app\BaseController;
use think\db\exception\{DataNotFoundException,DbException,ModelNotFoundException};
use think\facade\Request;
use think\response\Json;

class Login extends BaseController
{
    use BaseModel;

    /**
     * @throws DataNotFoundException
     * @throws ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws DbException
     */
    public function mobileLogin(): Json
    {
        $param  = (new LoginValidate())->getCheck('mobileLogin');
        //加密
        //echo password_hash("123456", PASSWORD_DEFAULT);
        //解密
        //password_verify('123456', $hash)
        $find = $this->loginModel
            ->with([
                'user'=>function($query){
                    $query
                        ->field('id,nickname,signature,avatar,bg_image,integral,sex,birthday');
                }
            ])
            ->where('mobile', $param['mobile'])
            ->find();
        if(!$find){
            return $this->error(202);
        }
        if(!password_verify($param['password'], $find['password'])){
            return $this->error(203);
        }
        if(!$find->user){
            return $this->error(205);
        }
        //更新数据
        //后期处理登录设备
        $find->last_login_ip = Request::ip();
        $find->save();

        //获取token
        $token = createToken($find->user->id);
        return $this->success([
            'userinfo'  =>  $find->user,
            'token'     =>  $token
        ],'登录成功');
    }
}
