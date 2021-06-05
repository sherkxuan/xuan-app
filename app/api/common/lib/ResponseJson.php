<?php
declare(strict_types=1);

namespace app\api\common\lib;


use think\facade\Config;
use think\response\Json;

trait ResponseJson
{
        //一般以配置文件( config/status.php )或者类的常量来定义错误码, 统一管理便于维护
    /**
     * @param mixed $data
     * @param string $msg
     * @return Json
     */
    public function success($data = '',string $msg = ''): Json
    {
        //始终不输出用户uid
        if(isset($data['user_id']))unset($data['user_id']);
        $data = array_map(function($item){
            if(isset($item['user_id'])){
                unset($item['user_id']);
            }
            return $item;
        },is_array($data)?$data:$data->toArray());
        $status = 200;
        return $this->restful($status,$msg?:'success',$data);
    }

    /**
     * @param $status
     * @param null $msg
     * @param null $data
     * @param int $httpCode
     * @return Json
     * 错误消息默认200，表示服务器已接受到数据，并进行处理。500为服务器内部错误
     */
    public function error($status, $msg = null, $data = null, int $httpCode = 200): Json
    {
        $message = Config::get('status.error.'.$status)??'未知错误';
        return $this->restful($status,$msg?:$message,$data,$httpCode);
    }

    /**
     * @param $status
     * @param $msg
     * @param $data
     * @param int $httpCode
     * @return Json
     */
    private function restful($status,$msg,$data,int $httpCode = 200): Json
    {
        $result = [
            'code'=>$status,
            'msg'=>$msg,
            'data'=>$data,
            'time'=>time()
        ];
        return json($result,$httpCode);
    }
}