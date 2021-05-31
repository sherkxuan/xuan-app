<?php
declare (strict_types = 1);

namespace app\api\validate;

class LoginValidate extends BaseValidate
{
    /**
     * 定义验证规则
     * 格式：'字段名' =>  ['规则1','规则2'...]
     *
     * @var array
     */
    protected $rule = [
        'mobile'  => 'require|mobile',
        'password'=>'require|length:6,21',
        'email' => 'require|email'
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名' =>  '错误信息'
     *
     * @var array
     */
    protected $message = [];

    protected $scene = [
        'mobileLogin'=>['mobile','password'],
        'emailLogin'=>['email','password']
    ];
}

