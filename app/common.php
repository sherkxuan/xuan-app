<?php /** @noinspection SpellCheckingInspection */

// 应用公共文件
use think\facade\Request;

/**
 * 获取用户id
 * @throws Exception
 */
function getUid(string $token = ''){
    $token = $token?:Request::header('token');
    try{
        $Result = JWT::decode($token,'Sherk-668',['HS256']);
        $res = json_decode(json_encode($Result), true);
        $ip = Request::ip();
        if($ip!==$res['data']['ip']){
            throw new \think\exception\HttpException('206','非法登录');
        }
        //后期处理非法访问日志

        return $res['data']['uid'];
    }catch (\think\exception\HttpException $e){
        throw new Exception($e->getMessage(),$e->getStatusCode());
    }
    catch (Exception $e)
    {
        throw new Exception($e->getMessage(),'201');
    }
}