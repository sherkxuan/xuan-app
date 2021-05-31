<?php
declare (strict_types = 1);

namespace app\api\validate;


class TopicValidate extends BaseValidate
{
    /**
     * 定义验证规则
     * 格式：'字段名' =>  ['规则1','规则2'...]
     *
     * @var array
     */
    protected $rule = [
        'name'      =>  'require|length:4,20',
        'describe'  =>  'require|length:5,150',
        'cover'     =>  'url'
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名' =>  '错误信息'
     *
     * @var array
     */
    protected $message = [];

    protected $scene = [
        'create'=>['name','describe','cover']
    ];
}
