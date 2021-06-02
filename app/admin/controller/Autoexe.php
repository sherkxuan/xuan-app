<?php
declare (strict_types = 1);

namespace app\admin\controller;

use app\admin\model\User;
use app\BaseController;
use Curl\Curl;
use think\api\Client;

/**
 * 自带数据演示数据
 * Class Autoexe
 * @package app\admin\controller
 */
class Autoexe extends BaseController
{

    public function test(){
        $client = new Client('552ad9b55b319b3280b6e6758cdda649');
        $result = $client->constellationQuery()
            ->withConsName('双鱼座')
            ->withType('today')
            ->request();
        dd($result);
    }

    /**
     * 测试上传
     */
    public function uploadPage(){
        return view('uploadPage');
    }
    public function upload(){
        $file = $this->request->file('img');
        try {
            $savename = \think\facade\Filesystem::disk('qiniu')->putFile('avarat',$file);
        }catch (\Exception $e){
            dd($e->getMessage());
        }
        dd($savename);
    }
}
