<?php
declare (strict_types = 1);

namespace app\api\validate;

use think\exception\ValidateException;

class VerifyException extends ValidateException
{
    protected $code;
    public function __construct($error,$code=500)
    {
        parent::__construct($error);
        $this->code   = $code;
    }
    public function getStatus()
    {
        return $this->code;
    }
}
