<?php /** @noinspection SpellCheckingInspection */

// 应用公共文件
use Firebase\JWT\JWT;
use think\facade\Request;
//生成token
/**
 * @param $uid
 * @return string
 */
function createToken($uid): string
{
    $secret = 'Sherk-668';      //密匙
    $payload = [
        'iss'=>'zx',                //签发人(官方字段:非必需)
        'exp'=>time()+3600*24*1,     //过期时间(官方字段:非必需)
        //'exp'=>time()+15,     //过期时间(官方字段:非必需)
        'aud'=>'user',              //受众(官方字段:非必需)
        'nbf'=>time(),               //生效时间(官方字段:非必需)
        'iat'=>time(),               //签发时间(官方字段:非必需)
        'data'=>[
            'uid' => $uid,
            'ip'  =>  Request::ip(),
        ],        //自定义字段
    ];
    return JWT::encode($payload,$secret);
}
//验证token
/**
 * @param string $token
 * @return boolean
 * @throws Exception
 */
function checkToken(string $token = ''): bool
{
    $token = $token?:Request::header('token');
    try{
        $Result = JWT::decode($token,'Sherk-668',['HS256']);
        json_decode(json_encode($Result), true);
        return true;
    }
    catch (Exception $e)
    {
        throw new Exception('登录过期','201');
    }
}

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