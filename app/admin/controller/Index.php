<?php

namespace app\admin\controller;

use app\BaseController;
use think\facade\View;

class Index extends BaseController
{
    //模拟数据
    public function simulation(){
        if($this->request->param('num')){
            return rand(1,100);
        }
        return View::fetch();
    }
    public function index()
    {
        return $this->success('你成功的访问到了主页,访问时间:'.Date('Y-m-d H:i:s',time()));
    }
}
