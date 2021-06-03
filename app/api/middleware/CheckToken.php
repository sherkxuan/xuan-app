<?php
declare (strict_types = 1);

namespace app\api\middleware;

use Closure;
use Exception;
use thans\jwt\exception\JWTException;
use thans\jwt\exception\TokenBlacklistException;
use thans\jwt\exception\TokenBlacklistGracePeriodException;
use thans\jwt\JWTAuth as Auth;
use thans\jwt\middleware\JWTAuth;

class CheckToken extends JWTAuth
{

    public function __construct(Auth $auth)
    {
        parent::__construct($auth);
    }

    /**
     * @param $request
     * @param Closure $next
     * @return mixed
     * @throws Exception
     */
    public function handle($request, Closure $next)
    {


        try {
            $this->auth->auth();
        } catch (TokenBlacklistException $e) {
            throw new Exception($e->getMessage(),211);
        } catch (TokenBlacklistGracePeriodException $e) {
            throw new Exception($e->getMessage(),210);
        } catch (JWTException $e) {
            throw new Exception($e->getMessage(),201);
        }
        $ip = ($this->auth->auth())['ip']->getValue();
        if($ip!=$request->ip()){
            throw new Exception('非法地址访问',206);
        }
        $request->uid = ($this->auth->auth())['uid']->getValue();
        return $next($request);
    }
}
