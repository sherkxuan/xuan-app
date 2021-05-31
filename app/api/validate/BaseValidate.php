<?php
declare (strict_types = 1);

namespace app\api\validate;

use think\facade\Request;
use think\Validate;

class BaseValidate extends Validate
{
    public function getCheck($data = '',$code = 204): array
    {
        $param = Request::param();
        if($this->scene($data)->check($param)){
            return $param;
        }else{
            throw new VerifyException($this->getError(),$code);
        }
    }
}
