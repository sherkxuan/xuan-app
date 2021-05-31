<?php
namespace app;

use app\api\common\lib\ResponseJson;
use think\db\exception\{DataNotFoundException,DbException,ModelNotFoundException};
use think\exception\Handle;
use think\exception\HttpException;
use think\exception\HttpResponseException;
use think\exception\ValidateException;
use app\api\validate\VerifyException;
use think\Response;
use Throwable;

/**
 * 应用异常处理类
 */
class ExceptionHandle extends Handle
{
    use ResponseJson;
    /**
     * 不需要记录信息（日志）的异常类列表
     * @var array
     */
    protected $ignoreReport = [
        HttpException::class,
        HttpResponseException::class,
        ModelNotFoundException::class,
        DataNotFoundException::class,
        ValidateException::class,
        VerifyException::class
    ];

    /**
     * 记录异常信息（包括日志或者其它方式记录）
     *
     * @access public
     * @param  Throwable $exception
     * @return void
     */
    public function report(Throwable $exception): void
    {
        // 使用内置的方式记录异常日志
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @access public
     * @param \think\Request   $request
     * @param Throwable $e
     * @return Response
     */
    public function render($request, Throwable $e): Response
    {
        // 添加验证自定义异常处理机制
        //api添加上$request->isAjax
        if($request->isAjax()){
            if ($e instanceof VerifyException) {
                return $this->error($e->getStatus(),$e->getError());
            }
            //处理http请求异常
            if ($e instanceof HttpException){
                return $this->error($e->getStatusCode(),$e->getMessage(),'',$e->getStatusCode());
            }
            //处理DB类异常
            if($e instanceof DbException){
                return $this->error($e->getCode(),$e->getMessage(),'',500);
            }
            //处理公共异常
            if($e instanceof \Exception){
                return $this->error($e->getCode(),$e->getMessage());
            }
        }
        // 其他错误交给系统处理
        return parent::render($request, $e);
    }
}
